<?php

namespace App\Controllers;

use App\Models\Users;
use App\Helpers\JwtHelpers;
use App\Controllers\BaseController;
use DateTime;

class AuthController extends BaseController
{

    protected $Users, $JwtHelpers;
    public function __construct()
    {
        $this->Users = new Users();
        $this->JwtHelpers = new JwtHelpers();
    }

    public function index()
    {
        $session = session()->get('sessionData');
        if ($session && $session['jwt_token']) {
            return redirect()->back();
        }
        return view('pages/login/login_page');
    }

    public function back()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function login()
    {
        $body = $this->request->getPost();
        $session = session();
        $rules = $this->Users->getValidationRules();
        $rules['username'] = 'required';
        $rules['password'] = 'required';
        unset($rules['role']);

        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
            $session->setFlashdata('errors', 'Login gagal input tidak sah!');
            return redirect()->back();
        }

        $failed = [];
        if (preg_match('/[&%|]/', $body['username'])) {
            $failed += ['username' => 'Karakter "& % |" tidak diizinkan.'];
        }

        if (preg_match('/[&%|]/', $body['password'])) {
            $failed += ['password' => 'Karakter "& % |" tidak diizinkan.'];
        }

        if ($failed) {
            $session->setFlashdata('_ci_validation_errors', $failed);
            return redirect()->back()->withInput();
        }

        if (!$this->validateData($body, $rules, $this->Users->getValidationMessages())) {
            return redirect()->back()->withInput();
        } else {
            $user = $this->Users->getUser($body['username']);
            if ($user && $body['username'] === $user['username'] && password_verify($body['password'], $user['password'])) {
                $unique = uniqid();
                $iat = time();
                $exp = time() + (getenv('SESSION_TOKEN') * 60);
                $generateToken = [
                    'iss' => getenv('ISS'),
                    'sub' => 'authToken',
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'unique' => $unique,
                    'updated_at' => $user['updated_at'],
                    'iat' => $iat,
                    'exp' => $exp
                ];

                $token = $this->JwtHelpers->generateToken($generateToken);
                $this->SessionHelpers->setSession('jwt_token', $token);

                $lastLogin = new DateTime($user['updated_at']);
                $time =  new DateTime();

                $loginTime = $lastLogin->diff($time)->h;
                if ($loginTime >= 1) {
                    $data = [
                        'status' => null
                    ];
                    $this->Users->update($user['id'], $data);
                    $user['status'] = $data['status'];
                }

                if ($token && !$user['status']) {
                    $data = [
                        'status' => $unique
                    ];
                    $this->Users->update($user['id'], $data);
                    return redirect()->to('/dashboard');
                } else {
                    $this->SessionHelpers->setSession('username', $user['username']);
                    return redirect()->to('/auth/online');
                }
            } else {
                session()->setFlashdata('errors', 'Username atau Password salah!');
                return redirect()->back();
            }
        }
    }

    public function online()
    {
        $data = [
            'title' => 'User Online',
            'link' => 'back'
        ];
        return view('pages/login/online_page', $data);
    }

    public function removeOnline()
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
                $session = $this->SessionHelpers->getSession();
                $sessionToken = str_replace('Bearer ', '', $session['jwt_token']);
                $token = $this->JwtHelpers->decodeToken($sessionToken);
                $body = [
                    'status' => $token->unique
                ];

                if ($this->Users->update($users['id'], $body)) {
                    $this->SessionHelpers->removeSession(['online']);
                    return redirect()->to('/dashboard');
                } else {
                    session()->setFlashdata('errors', 'Penghapusan hak akses gagal!');
                    return redirect()->back();
                }
            }
        } else {
            session()->setFlashdata('errors', 'Data user Tidak Ditemukan');
            return redirect()->back();
        }
    }

    public function logOut()
    {
        $session = $this->SessionHelpers->getSession();
        $body = $this->request->getPost();
        if (!isset($body[csrf_token()]) || $body[csrf_token()] != csrf_hash()) {
            $body = null;
        }

        if ($session && isset($session['jwt_token'])) {
            $dataToken = $this->JwtHelpers->decodeToken($session['jwt_token']);
            $user = null;

            if ($body && isset($body['username']) == $dataToken->username) {
                $user = $this->Users->getUser($dataToken->username);
            }

            if ($user) {
                $this->Users->update($user['id'], [
                    'status' => null
                ]);
                session()->destroy();
                return redirect()->to('/');
            } else {
                session()->setFlashdata('errors', 'Logout gagal!');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('errors', 'Logout gagal!');
            return redirect()->back();
        }
    }
}
