<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;

class AuthController extends BaseController
{

    protected $Users;
    public function __construct()
    {
        $this->Users = new Users();
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

        if (!$this->validateData($data, $rules, $this->Users->getValidationMessages())) {
            return redirect()->back()->withInput();
        } else {
            $user = $this->Users->getUser($data['username']);
            if ($user && $data['username'] === $user['username'] && password_verify($data['password'], $user['password'])) {

                $dataToken = [
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'updated_at' => $user['updated_at'],
                ];

                $token = $this->Users->generateToken($dataToken);

                if ($token) {
                    $dt = [
                        'token' => $token
                    ];
                    $session->set('jwt_token', $token);
                    $this->Users->update($user['id'], $dt);
                    $role = $user['role'];
                    return redirect()->to('/dashboard');
                }
            } else {
                session()->setFlashdata('fail', 'Email atau Password salah!');
                return redirect()->back();
            }
        }
    }

    public function logOut()
    {
        $session = session();
        $data = $session->get('jwt_token');

        if ($data) {
            $dataToken = $this->Users->decodeToken($data);
            $user = $this->Users->getUser($dataToken->username);
            if ($user) {
                $this->Users->update($user['id'], [
                    'token' => null
                ]);
                $session->remove('jwt_token');
                $session->remove('role');
                return redirect()->to('/');
            }
        }
    }
}
