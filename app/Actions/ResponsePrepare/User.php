<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class User
{
  public function __invoke(Collection $users)
  {
    $response = [];

    foreach ($users as $user) {
      array_push($response, [
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
      ]);
    }

    return $response;
  }

  public function one(Model $user): array
  {
    $response =  [
      'userInfo' => [
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
      ],
      'workSchedules' => $this->formatWorkShedules($user->work_schedules),
    ];

    return $response;
  }

  public function formatWorkShedules(Collection $workSchedules)
  {
    $formatWorkSchedules = [];
    foreach ($workSchedules as $workSchedule) {
      array_push($formatWorkSchedules, [
        'id' => $workSchedule->id,
        'startTime' => $this->formateUserTime($workSchedule->start_time),
        'endTime' => $this->formateUserTime($workSchedule->end_time),
        'dayOfWeek' => $workSchedule->day_of_week,
      ]);
    }
    return $formatWorkSchedules;
  }

  private function formateUserTime(string $time)
  {
    $dateTime = strtotime($time);
    $formatedTime = date('H:i', $dateTime);
    return $formatedTime;
  }
}
