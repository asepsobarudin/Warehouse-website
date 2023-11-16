<?php

namespace App\Filters;

use App\Helpers\JwtHelpers;
use App\Helpers\SessionHelpers;
use App\Models\Users;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\ExpiredException;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */

    protected $Users, $JwtHelpers, $SessionHelpers;
    public function __construct()
    {
        $this->Users = new Users();
        $this->JwtHelpers = new JwtHelpers();
        $this->SessionHelpers = new SessionHelpers;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = $this->SessionHelpers->getSession();
        if (isset($session['jwt_token'])) {
            try {
                $decoded = $this->JwtHelpers->decodeToken($session['jwt_token']);
                $user = $this->Users->getStatus($decoded->username);
                if ($decoded && $user['status'] === $decoded->unique) {
                    $role = $decoded->role;
                    $this->SessionHelpers->setSession('role', $role);
                    $this->SessionHelpers->setSession('username', $decoded->username);

                    $timeToken = getenv('SESSION_TOKEN');
                    $expire = $decoded->exp - ($timeToken * 30);
                    if (time() > $expire) {
                        $unique = uniqid();
                        $iat = time();
                        $exp = time() + ($timeToken * 60);
                        $dataToken = [
                            'iss' => $decoded->iss,
                            'sub' => $decoded->sub,
                            'username' => $decoded->username,
                            'role' => $decoded->role,
                            'unique' => $unique,
                            'updated_at' => $decoded->updated_at,
                            'iat' => $iat,
                            'exp' => $exp
                        ];

                        if ($this->Users->update($user['id'], ['status' => $dataToken['unique']])) {
                            $refreshToken = $this->JwtHelpers->generateToken($dataToken);
                            $this->SessionHelpers->setSession('jwt_token', $refreshToken);
                        }
                    }

                    if ($arguments != null) {
                        $index = array_search($role, $arguments);
                        if ($arguments[$index] && $role === $arguments[$index]) {
                            return $request;
                        } else {
                            return redirect()->back();
                        }
                    } else {
                        return $request;
                    }
                } else if ($decoded && $decoded->unique) {
                    if ($arguments != null && $arguments[0] === 'online') {
                        return $request;
                    } else {
                        $this->SessionHelpers->deleteSession();
                        session()->setFlashdata('errors', 'Anda telah keluar dari sistem!');
                        return redirect()->to('/');
                    }
                } else {
                    session()->destroy();
                    return redirect()->to('/');
                }
            } catch (ExpiredException $e) {
                $username = $session['username'];
                if ($username) {
                    $user = $this->Users->getUser($username);
                    $this->Users->update($user['id'], [
                        'status' => null
                    ]);
                }
                $this->SessionHelpers->deleteSession();
                session()->setFlashdata('errors', 'Sesi login anda telah berakhir!');
                return redirect()->to('/');
            }
        } else {
            session()->destroy();
            return redirect()->to('/');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
