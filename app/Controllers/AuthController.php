<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\JwtHelpers;
use App\Models\Users;

class AuthController extends BaseController
{

    protected $Users;
    protected $JwtHelpers;
    public function __construct()
    {
        $this->Users = new Users();
        $this->JwtHelpers = new JwtHelpers();
    }

    public function index()
    {
        if (session('jwt_token')) {
            return redirect()->back();
        }
        return view('pages/login/login_page');
    }

    public function login()
    {
        $data = $this->request->getPost();
        $session = session();

        $rules = $this->Users->getValidationRules();
        $rules['username'] = 'required';
        $rules['password'] = 'required';
        unset($rules['passwordConf']);
        unset($rules['role']);

        $failed = [];
        if (preg_match('/[&%|]/', $data['username'])) {
            $failed += ['username' => 'Karakter "& % |" tidak diizinkan.'];
        }

        if (preg_match('/[&%|]/', $data['password'])) {
            $failed += ['password' => 'Karakter "& % |" tidak diizinkan.'];
        }

        if ($failed) {
            $session->setFlashdata('_ci_validation_errors', $failed);
            return redirect()->back()->withInput();
        }

        if (!$this->validateData($data, $rules, $this->Users->getValidationMessages())) {
            return redirect()->back()->withInput();
        } else {
            $user = $this->Users->getUser($data['username']);

            if ($user && $data['username'] === $user['username'] && password_verify($data['password'], $user['password'])) {
                $unique = uniqid();

                $iat = time();
                $exp = time() + (getenv('SESSION_TOKEN') * 60);
                $dataToken = [
                    'iss' => getenv('ISS'),
                    'sub' => 'authToken',
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'unique' => $unique,
                    'updated_at' => $user['updated_at'],
                    'iat' => $iat,
                    'exp' => $exp
                ];

                $token = $this->JwtHelpers->generateToken($dataToken);
                $session->set('jwt_token', $token);
                if ($token && !$user['status']) {
                    $dt = [
                        'status' => $unique
                    ];
                    $this->Users->update($user['id'], $dt);
                    return redirect()->to('/dashboard');
                } else {
                    $session->set('online', $user['username']);
                    return redirect()->to('/auth/online');
                }
            } else {
                session()->setFlashdata('fail', 'Email atau Password salah!');
                return redirect()->back();
            }
        }
    }

    public function online()
    {
        session()->remove('username');
        return view('pages/login/online_page');
    }

    public function removeOnline()
    {
        $data = $this->request->getPost();
        if ($data && isset($data['username'])) {
            $users = $this->Users->getUser($data['username']);
            if (!$users) {
                session()->setFlashdata('failed', 'Username tidak ditemukan!');
                return redirect()->back();
            } else {
                $sessionToken = str_replace('Bearer ', '',  session()->get('jwt_token'));
                $token = $this->JwtHelpers->decodeToken($sessionToken);
                $data = [
                    'status' => $token->unique
                ];

                if ($this->Users->update($users['id'], $data)) {
                    session()->remove('online');
                    return redirect()->to('/dashboard');
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

    public function logOut()
    {
        $session = session();
        $data = $session->get('jwt_token');

        if ($data) {
            $dataToken = $this->JwtHelpers->decodeToken($data);
            $user = $this->Users->getUser($dataToken->username);
            if ($user) {
                $this->Users->update($user['id'], [
                    'status' => null
                ]);
                $session->destroy();
                return redirect()->to('/');
            }
        }
    }
}
