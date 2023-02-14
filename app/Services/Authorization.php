<?php

namespace App\Services;

use App\Models\Role as ModelsRole;
use App\Models\User as ModelsUser;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    $credentials = $validator->validated();
    $user = ModelsUser::where('login', $credentials['login'])->first();
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
      throw new Exception('invalid password or login');
    }

    $role = ModelsRole::select('title', 'alias')->where('id', $user->role_id)->first();

    $response = [
      'id' => $user->id,
      'login' => $user->login,
      'name' => $user->name,
      'token' => $user->createToken($user->login)->plainTextToken,
      'role' => $role->title,
      'roleAlias' => $role->alias,
    ];

    return $response;
  }
}
