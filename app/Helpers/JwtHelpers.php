<?php

namespace App\Helpers;

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelpers
{
  public function generateToken($data)
  {
    $key = getenv('JWT_SECRET');
    $algoritma = 'HS256';
    $token = JWT::encode($data, $key, $algoritma);
    return $token;
  }

  public function decodeToken($token)
  {
    $key = getenv('JWT_SECRET');
    $algoritma = 'HS256';
    $decoded = JWT::decode($token, new Key($key, $algoritma));
    return $decoded;
  }
}
