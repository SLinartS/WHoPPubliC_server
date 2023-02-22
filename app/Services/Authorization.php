<?php

namespace App\Services;

use App\Models\Role as ModelsRole;
use App\Models\Token as ModelsToken;
use App\Models\User as ModelsUser;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use ReallySimpleJWT\Token as JWTToken;

class Authorization
{
  public function login(string $login, string $password)
  {
    $validator  = Validator::make(
      [
        'login' => $login,
        'password' => $password
      ],
      [
        'login' => ['required'],
        'password' => ['required'],
      ]
    );

    if ($validator->fails()) {
      throw new Exception('invalid password or login');
    }

    $user = ModelsUser::where('login', $login)->first();

    if (!Hash::check($password, $user->password)) {
      throw new Exception('invalid password or login');
    }

    $access = (new Token())->createAccessToken($user->id);
    $refresh = (new Token())->createRefreshToken($user->id);

    $tokens = ModelsToken::where('user_id', $user->id)->first();
    if (!$tokens) {
      $tokens = new ModelsToken();
    }

    $tokens->user_id = $user->id;
    $tokens->access = $access;
    $tokens->refresh = $refresh;
    $tokens->save();

    return $this->getUserData($access, $refresh, $user);
  }

  public function logout(string $accessToken, int $userId)
  {
    if (!$accessToken) {
      throw new Exception('logout error');
    }

    ModelsToken::where('user_id', $userId)->orWhere('access', $accessToken)->delete();
  }

  public function refresh(string $refreshToken)
  {
    if (!$refreshToken) {
      throw new Exception('token error');
    }

    if (!JWTToken::validate($refreshToken, env('JWT_REFRESH_SECRET'))) {
      throw new Exception('token validate error');
    }

    if (!JWTToken::validateExpiration($refreshToken)) {
      throw new Exception('token expired');
    }

    $token = ModelsToken::where('refresh', $refreshToken)->first();
    if (!$token) {
      throw new Exception('this token not found');
    }

    $user = ModelsUser::where('id', $token->user_id)->first();
    if (!$user) {
      throw new Exception('the user does not have a token');
    }

    $access = (new Token())->createAccessToken($user->id);
    $refresh = (new Token())->createRefreshToken($user->id);

    $tokens = ModelsToken::where('user_id', $user->id)->first();
    if (!$tokens) {
      $tokens = new ModelsToken();
    }

    $tokens->user_id = $user->id;
    $tokens->access = $access;
    $tokens->refresh = $refresh;
    $tokens->save();

    return $this->getUserData($access, $refresh, $user);
  }

  private function getUserData(string $access, string $refresh, Model $user)
  {
    $role = ModelsRole::select('title', 'alias')->where('id', $user->role_id)->first();

    $response = [
      'userData' => [
        'id' => $user->id,
        'login' => $user->login,
        'name' => $user->name,
        'role' => $role->title,
        'roleAlias' => $role->alias,
      ],
      'tokens' => [
        'access' => $access,
        'refresh' => $refresh,
      ]
    ];

    return $response;
  }
}
