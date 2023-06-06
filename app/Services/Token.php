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

      $secret = config('app.jwt_access_secret');

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

      $secret = config('app.jwt_refresh_secret');

      $token = JWTToken::customPayload($payload, $secret);
      return $token;
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}
