<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;

class Account
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
        'role' => [
          'value' => $users->role,
          'alias' => 'Роль'
        ],
      ]);
    }

    return $response;
  }
}
