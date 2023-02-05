<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class User
{
  public function __invoke(Collection $users)
  {
    $response = [];

    foreach ($users as $users) {
      array_push($response, [
        'id' => [
          'value' => $users->id,
          'alias' => 'ID'
        ],
        'email' => [
          'value' => $users->email,
          'alias' => 'Почта'
        ],
        'phone' => [
          'value' => $users->phone,
          'alias' => 'Телефон'
        ],
        'login' => [
          'value' => $users->login,
          'alias' => 'Логин'
        ],
        'password' => [
          'value' => '',
          'alias' => 'Пароль'
        ],
        'name' => [
          'value' => $users->name,
          'alias' => 'Имя'
        ],
        'surname' => [
          'value' => $users->surname,
          'alias' => 'Фамилия'
        ],
        'patronymic' => [
          'value' => $users->patronymic,
          'alias' => 'Отчество'
        ],
        'roleId' => [
          'value' => $users->role_id,
          'alias' => 'role_id'
        ],
        'roleAlias' => [
          'value' => $users->role,
          'alias' => 'Роль'
        ],
      ]);
    }

    return $response;
  }

  public function one(Model $user): array
  {
    $response =  [
      'id' => [
        'value' => $user->id,
        'alias' => 'ID'
      ],
      'email' => [
        'value' => $user->email,
        'alias' => 'Почта'
      ],
      'phone' => [
        'value' => $user->phone,
        'alias' => 'Телефон'
      ],
      'login' => [
        'value' => $user->login,
        'alias' => 'Логин'
      ],
      'password' => [
        'value' => '',
        'alias' => 'Пароль'
      ],
      'name' => [
        'value' => $user->name,
        'alias' => 'Имя'
      ],
      'surname' => [
        'value' => $user->surname,
        'alias' => 'Фамилия'
      ],
      'patronymic' => [
        'value' => $user->patronymic,
        'alias' => 'Отчество'
      ],
      'roleId' => [
        'value' => $user->role_id,
        'alias' => 'role_id'
      ],
      'roleAlias' => [
        'value' => $user->role,
        'alias' => 'Роль'
      ],
    ];


    return $response;
  }
}
