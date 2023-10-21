<?php

namespace App\Filters;

use App\Models\Users;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

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

    protected $User;
    public function __construct()
    {
        $this->User = new Users();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $token = str_replace('Bearer ', '',  $session->get('jwt_token'));
        if($token){
            $user = $this->User->getToken($token);
        }
        
        if ($token && $token == isset($user)) {
            $decoded = JWT::decode($token, new Key('tokoKitaNo1', 'HS256'));
            $role = $decoded->role;
            $session->set('role', $role);

            if($arguments != null){
                $index = array_search($role, $arguments);
            }

            if (isset($arguments[isset($index)]) && $role === $arguments[$index]) {
                return $request;
            } else if ($arguments === null && $token) {
                return $request;
            } else {
                return redirect()->to('/access-denied');
            }
        } else {
            $session->remove('jwt_token');
            $session->remove('role');
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
