<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;

class UserController extends BaseController
{
    protected $Users;
    public function __construct()
    {
        $this->Users = new Users();
    }

    public function index()
    {
        $getUser = $this->Users->getAllUser();
        $setUser = [];

        foreach ($getUser as $user) {
            unset($user['id']);
            unset($user['password']);

            if ($user['token']) {
                $user['token'] = 'online';
            } else {
                $user['token'] = null;
            }

            $setUser = array_merge($setUser, [$user]);
        }

        $data = [
            'title' => 'User',
            'user' => $setUser
        ];

        return view('pages/admin/users_page', $data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        if ($data) {
            if ($data['role'] === '0') {
                $data['role'] = null;
            }

            if ($data['role'] != 'kasir' && $data['role'] != 'gudang' && $data['role'] != 'admin') {
                $data['role'] = null;
            }

            $rules = $this->Users->getValidationRules();
            $rules = array_merge($rules, ['passwordConf' => 'matches[password]']);
            $message = $this->Users->getValidationMessages();
            $message = array_merge($message, [
                'passwordConf' => [
                    'matches' => 'password konfirmasi tidak cocok!'
                ]
            ]);

            if (!$this->validateData($data, $rules, $message)) {
                return redirect()->back()->withInput();
            } else {
                $password = password_hash($data['password'], PASSWORD_BCRYPT);

                $this->Users->insert([
                    'username' => $data['username'],
                    'password' => $password,
                    'role' => $data['role'],
                ]);

                session()->setFlashdata('success', 'User berhasil di tambahkan');
                return redirect()->to('/users');
            }
        } else {
            $data = [
                'title' => 'Buat User Baru',
                'link' => '/users'
            ];
            return view('pages/admin/users_create', $data);
        }
    }

    public function edit($username)
    {
        $users = $this->Users->getUser($username);
        unset($users['id']);

        $data = [
            'title' => 'Update Password dan Role',
            'link' => '/users',
            'users' => $users
        ];
        return view('pages/admin/users_edit', $data);
    }

    public function update()
    {
        $data = $this->request->getPost();

        if ($data && isset($data['username'])) {
            $users = $this->Users->getUser($data['username']);

            if (!$users) {
                session()->setFlashdata('failed', 'Username tidak ditemukan!');
                return redirect()->back();
            } else {
                $rules = $this->Users->getValidationRules();
                $rules = array_merge($rules, ['passwordConf' => 'matches[password]']);
                $rules['username'] = 'required|min_length[4]';
                $message = $this->Users->getValidationMessages();
                $message = array_merge($message, [
                    'passwordConf' => [
                        'matches' => 'password konfirmasi tidak cocok!'
                    ]
                ]);

                if (!$this->validateData($data, $rules, $message)) {
                    return redirect()->back()->withInput();
                } else {
                    $password = password_hash($data['password'], PASSWORD_BCRYPT);
                    $data = [
                        'password' => $password,
                        'role' => $data['role'],
                        'token' => null
                    ];

                    if ($this->Users->update($users['id'], $data)) {
                        session()->setFlashdata('success', 'Username Berhasil Di Ubah!');
                        return redirect()->to('/users');
                    } else {
                        session()->setFlashdata('failed', 'Update Gagal!');
                        return redirect()->back();
                    }
                }
            }
        } else {
            session()->setFlashdata('failed', 'Data Tidak Ditemukan');
            return redirect()->back();
        }
    }

    public function delete()
    {
        $data = $this->request->getPost();
        if ($data && isset($data['username'])) {
            $users = $this->Users->getUser($data['username']);

            if (!$users) {
                session()->setFlashdata('failed', 'Username tidak ditemukan!');
                return redirect()->back();
            } else {
                if ($this->Users->delete($users['id'])) {
                    session()->setFlashdata('success', 'User Berhasil Di Hapus!');
                    return redirect()->to('/users');
                } else {
                    session()->setFlashdata('failed', ' Gagal Menghapus User!');
                    return redirect()->back();
                }
            }
        } else {
            session()->setFlashdata('failed', 'Data Tidak Ditemukan');
            return redirect()->back();
        }
    }

    public function removeAccess()
    {
        $data = $this->request->getPost();
        if ($data && isset($data['username'])) {
            $users = $this->Users->getUser($data['username']);

            if (!$users) {
                session()->setFlashdata('failed', 'Username tidak ditemukan!');
                return redirect()->back();
            } else {
                $data = [
                    'token' => null
                ];

                if ($this->Users->update($users['id'], $data)) {
                    session()->setFlashdata('success', 'Access user ' . $users['username'] . 'berhasil di tutup');
                    return redirect()->to('/users');
                } else {
                    session()->setFlashdata('failed', 'Penghapusan hak akses gagal!');
                    return redirect()->back();
                }
            }
        } else {
            session()->setFlashdata('failed', 'Data Tidak Ditemukan');
            return redirect()->back();
        }
    }
}
