<?php

namespace App\Filters;

use App\Helpers\JwtHelpers;
use App\Models\Users;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\CachedKeySet;

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

    protected $Users;
    protected $JwtHelpers;
    public function __construct()
    {
        $this->Users = new Users();
        $this->JwtHelpers = new JwtHelpers();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $token = str_replace('Bearer ', '',  $session->get('jwt_token'));

        if ($token) {
            try {
                $decoded = $this->JwtHelpers->decodeToken($token);
                $user = $this->Users->getStatus($decoded->username);
                if ($decoded && $user === $decoded->unique) {
                    $role = $decoded->role;
                    $session->set('role', $role);
                    $session->set('username', $decoded->username);

                    $timeToken = getenv('SESSION_TOKEN');
                    $expire = $decoded->exp - ($timeToken * 30);
                    if (time() > $expire) {
                        $iat = time();
                        $exp = time() + ($timeToken * 60);
                        $dataToken = [
                            'iss' => $decoded->iss,
                            'sub' => $decoded->sub,
                            'username' => $decoded->username,
                            'role' => $decoded->role,
                            'unique' => $decoded->unique,
                            'updated_at' => $decoded->updated_at,
                            'iat' => $iat,
                            'exp' => $exp
                        ];
                        $refreshToken = $this->JwtHelpers->generateToken($dataToken);
                        $session->set('jwt_token', $refreshToken);
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
                        $session->remove('jwt_token');
                        $session->remove('role');
                        $session->remove('username');
                        session()->setFlashdata('fail', 'Hak akses anda telah dicabut!');
                        return redirect()->to('/');
                    }
                } else {
                    $session->destroy();
                    return redirect()->to('/');
                }
            } catch (ExpiredException $e) {
                $username = $session->get('username');
                if ($username) {
                    $user = $this->Users->getUser($username);
                    $this->Users->update($user['id'], [
                        'status' => null
                    ]);
                }
                $session->destroy();
                $session->setFlashdata('fail', 'Sesi login anda telah berakhir!');
                return redirect()->to('/');
            }
        } else {
            $session->destroy();
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
