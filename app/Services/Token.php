<?php

namespace App\Services;

use ReallySimpleJWT\Token as JWTToken;

class Token
{
  public function createAccessToken($userId)
  {
    try {
      $payload = [
        'iat' => time(),
        'uid' => $userId,
        'exp' => time() + 60 * 30,
        'iss' => 'localhost'
      ];

      $secret = env('JWT_ACCESS_SECRET');

      $token = JWTToken::customPayload($payload, $secret);
      return $token;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function createRefreshToken($userId)
  {
    try {
      $payload = [
        'iat' => time(),
        'uid' => $userId,
        'exp' => time() + 24 * 60 * 60,
        'iss' => 'localhost'
      ];

      $secret = env('JWT_REFRESH_SECRET');

      $token = JWTToken::customPayload($payload, $secret);
      return $token;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
