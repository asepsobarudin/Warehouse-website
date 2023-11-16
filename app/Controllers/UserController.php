<?php

namespace App\Controllers;

use DateTime;
use App\Models\Users;
use App\Controllers\BaseController;
use App\Helpers\SessionHelpers;

class UserController extends BaseController
{
    protected $Users, $Session;
    public function __construct()
    {
        $this->Users = new Users();
        $this->Session = new SessionHelpers();
    }

    public function index()
    {
        $getUser = $this->Users->getAllUser();
        $setUser = [];

        foreach ($getUser as $user) {
            $lastLogin = new DateTime($user['updated_at']);
            $time =  new DateTime();

            $loginTime = $lastLogin->diff($time)->h;
            if ($loginTime >= 1 && $user['status']) {
                $dt = [
                    'status' => null
                ];
                $this->Users->update($user['id'], $dt);
                $user['status'] = $dt['status'];
            }

            if ($user['status']) {
                $user['status'] = 'online';
            } else {
                $user['status'] = null;
            }

            unset($user['id']);
            unset($user['password']);
            $setUser = array_merge($setUser, [$user]);
        }

        $data = [
            'title' => 'User',
            'user' => $setUser
        ];

        return view('pages/users/users_page', $data);
    }

    public function create()
    {
        $body = $this->request->getPost();
        if ($body) {
            if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
                $body = null;
                session()->setFlashdata('errors', 'User gagal ditambahkan!');
                return redirect()->back()->withInput();
            }

            if ($body['role'] === '0') {
                $body['role'] = null;
            }

            if ($body['role'] != 'kasir' && $body['role'] != 'gudang' && $body['role'] != 'admin') {
                $body['role'] = null;
            }

            $rules = $this->Users->getValidationRules();
            $rules = array_merge($rules, ['passwordConf' => 'matches[password]']);
            $message = $this->Users->getValidationMessages();
            $message = array_merge($message, [
                'passwordConf' => [
                    'matches' => 'Password konfirmasi tidak cocok!'
                ]
            ]);

            if (!$this->validateData($body, $rules, $message)) {
                return redirect()->back()->withInput();
            } else {
                $password = password_hash($body['password'], PASSWORD_BCRYPT);

                $this->Users->insert([
                    'username' => $body['username'],
                    'password' => $password,
                    'role' => $body['role'],
                ]);

                session()->setFlashdata('success', 'User berhasil di tambahkan');
                return redirect()->to('/users');
            }
        } else {
            $data = [
                'title' => 'Buat User Baru',
                'link' => '/users'
            ];
            return view('pages/users/users_create', $data);
        }
    }

    public function edit($username)
    {
        $users = $this->Users->getUser($username);
        unset($users['password']);

        $data = [
            'title' => 'Update Password dan Role',
            'link' => '/users',
            'users' => $users
        ];
        return view('pages/users/users_edit', $data);
    }

    public function update()
    {
        $body = $this->request->getPost();

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['username'])) {
            $users = $this->Users->getUser($body['username']);

            if (!$users) {
                session()->setFlashdata('errors', 'Username tidak ditemukan!');
                return redirect()->back();
            } else {
                $rules = $this->Users->getValidationRules();
                $rules = array_merge($rules, ['passwordConf' => 'matches[password]']);
                $rules['username'] = 'required|min_length[4]';
                $message = $this->Users->getValidationMessages();
                $message = array_merge($message, [
                    'passwordConf' => [
                        'matches' => 'Password konfimasi tidak cocok!'
                    ]
                ]);

                if ($body['role'] === '0') {
                    $body['role'] = null;
                }

                if ($body['role'] != 'kasir' && $body['role'] != 'gudang' && $body['role'] != 'admin') {
                    $body['role'] = null;
                }

                if (!$this->validateData($body, $rules, $message)) {
                    return redirect()->back()->withInput();
                } else {
                    if (password_verify($body['password'], $users['password'])) {
                        session()->setFlashdata('errors', 'Password yang sama dengan yang sekarang!');
                        return redirect()->back();
                    }

                    $password = password_hash($body['password'], PASSWORD_BCRYPT);
                    $data = [
                        'password' => $password,
                        'role' => $body['role'],
                        'status' => null
                    ];

                    if ($this->Users->update($users['id'], $data)) {
                        $session = session()->get('sessionData');
                        if ($session['username'] === $users['username']) {
                            $this->Session->deleteSession();
                        }
                        session()->setFlashdata('success', 'Update data user berhasil.');
                        return redirect()->to('/users');
                    } else {
                        session()->setFlashdata('errors', 'Update data user gagal!');
                        return redirect()->back();
                    }
                }
            }
        } else {
            session()->setFlashdata('errors', 'Data user tidak ditemukan!');
            return redirect()->back();
        }
    }

    public function delete()
    {
        $body = $this->request->getPost();
        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($body && isset($body['username'])) {
            $users = $this->Users->getUser($body['username']);

            if (!$users) {
                session()->setFlashdata('errors', 'Username tidak ditemukan!');
                return redirect()->back();
            } else {
                if ($this->Users->delete($users['id'])) {
                    session()->setFlashdata('success', 'User berhasil di hapus!');
                    return redirect()->to('/users');
                } else {
                    session()->setFlashdata('errors', ' Gagal menghapus user!');
                    return redirect()->back();
                }
            }
        } else {
            session()->setFlashdata('errors', 'Data user tidak ditemukan');
            return redirect()->back();
        }
    }

    public function removeAccess()
    {
        $body = $this->request->getPost();
        if ($body && isset($body['username'])) {
            $users = $this->Users->getUser($body['username']);

            if (!$users) {
                session()->setFlashdata('errors', 'Username tidak ditemukan!');
                return redirect()->back();
            } else {
                $data = [
                    'status' => null
                ];

                if ($this->Users->update($users['id'], $data)) {
                    session()->setFlashdata('success', 'Akses user ' . $users['username'] . ' berhasil di tutup.');
                    return redirect()->to('/users');
                } else {
                    session()->setFlashdata('errors', 'Penghapusan hak akses user gagal!');
                    return redirect()->back();
                }
            }
        } else {
            session()->setFlashdata('errors', 'Data user Tidak Ditemukan');
            return redirect()->back();
        }
    }
}
