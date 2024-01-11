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
        $body = $this->request->getPost();
        if ($body && isset($body['search_users']) && $body['search_users'] != "") {
            if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
                $body = null;
            }

            if (isset($body['search_users'])) {
                $users = $this->Users->getUser($body['search_users']);
                $setUsers = [];
                if (isset($users["online_status"])) {
                    $users["online_status"] = 'online';
                }
                unset($users['id']);
                unset($users['password']);

                $setUser = null;
                if ($users) {
                    $setUser = array_merge($setUsers, [$users]);
                }

                $data = [
                    'title' => 'Pengguna',
                    'user' => $setUser,
                ];

                return view('pages/users/users_page', $data);
            } else {
                session()->setFlashdata('errors', 'Data barang tidak ditemukan!');
                return redirect()->back();
            }
        } else {
            $getUser = $this->Users->getAllUser();
            $setUser = [];

            foreach ($getUser as $user) {
                $lastLogin = new DateTime($user['updated_at']);
                $time =  new DateTime();

                $loginTime = $lastLogin->diff($time)->h;
                if ($loginTime >= 1 && $user["online_status"]) {
                    $dt = [
                        "online_status" => null
                    ];
                    $this->Users->update($user['id'], $dt);
                    $user["online_status"] = $dt["online_status"];
                }

                if ($user["online_status"]) {
                    $user["online_status"] = 'online';
                } else {
                    $user["online_status"] = null;
                }

                unset($user['id']);
                unset($user['password']);
                $setUser = array_merge($setUser, [$user]);
            }

            $data = [
                'title' => 'Pengguna',
                'user' => $setUser
            ];

            return view('pages/users/users_page', $data);
        }
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

            if ($body['role'] != 'gudang' && $body['role'] != 'admin') {
                $body['role'] = null;
            }

            $failed = [];
            if (preg_match('/[&%|]/', $body['username'])) {
                $failed += ['username' => 'Karakter "& % |" tidak diizinkan.'];
            }

            if (preg_match('/[&%|]/', $body['password'])) {
                $failed += ['password' => 'Karakter "& % |" tidak diizinkan.'];
            }

            if ($failed) {
                session()->setFlashdata('_ci_validation_errors', $failed);
                return redirect()->back()->withInput();
            }

            $rules = $this->Users->getValidationRules();
            $rules = array_merge($rules, ['passwordConf' => 'matches[password]']);
            $message = $this->Users->getValidationMessages();
            $message = array_merge($message, [
                'passwordConf' => [
                    'matches' => 'Password konfirmasi tidak cocok!'
                ]
            ]);

            $password = password_hash($body['password'], PASSWORD_BCRYPT);

            $data = [
                'username' => $body['username'],
                'password' => $password,
                'role' => $body['role'],
            ];

            if ($this->validateData($body, $rules, $message) && $this->Users->insert($data)) {
                session()->setFlashdata('success', 'User berhasil di tambahkan.');
                return redirect()->to('/users');
            } else {
                session()->setFlashdata('error', 'User gagal di tambahkan!');
                return redirect()->back()->withInput();
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
            'title' => 'Edit user',
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
                unset($rules['username']);
                $this->Users->setValidationRules($rules);
                $message = $this->Users->getValidationMessages();
                $message = array_merge($message, [
                    'passwordConf' => [
                        'matches' => 'Password konfimasi tidak cocok!'
                    ]
                ]);

                if (!isset($body['role'])) {
                    unset($rules['role']);
                    $this->Users->setValidationRules($rules);
                }

                if (isset($body['role']) && $body['role'] === '0') {
                    $body['role'] = null;
                }

                if (isset($body['role']) && $body['role'] != 'gudang' && $body['role'] != 'admin') {
                    $body['role'] = null;
                }

                $failed = [];
                if (preg_match('/[&%|]/', $body['username'])) {
                    $failed += ['username' => 'Karakter "& % |" tidak diizinkan.'];
                }

                if (preg_match('/[&%|]/', $body['password'])) {
                    $failed += ['password' => 'Karakter "& % |" tidak diizinkan.'];
                }

                if ($failed) {
                    session()->setFlashdata('_ci_validation_errors', $failed);
                    return redirect()->back()->withInput();
                }

                if (!$this->validateData($body, $rules, $message)) {
                    return redirect()->back()->withInput();
                } else {
                    $session = session()->get('sessionData');
                    if (password_verify($body['password'], $users['password'])) {
                        session()->setFlashdata('errors', 'Password yang dimasukan sama dengan yang sekarang!');
                        return redirect()->back();
                    }

                    $password = password_hash($body['password'], PASSWORD_BCRYPT);

                    $data = [];
                    if ($session['username'] === $users['username']) {
                        $data = [
                            'password' => $password,
                            "online_status" => null
                        ];
                    } else {
                        $data = [
                            'password' => $password,
                            'role' => $body['role'],
                            "online_status" => null
                        ];
                    }

                    if ($this->Users->update($users['id'], $data)) {
                        if ($session['username'] === $users['username']) {
                            session()->destroy();
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
                    "online_status" => null
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
