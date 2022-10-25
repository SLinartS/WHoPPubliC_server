<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;

class TaskResponsePrepare
{

  public function __invoke(Collection $tasks)
  {
    $response = [
      'data' => [],
      'tableHeader' => []
    ];

    foreach ($tasks as $task) {

      $deadline = ((strtotime($task->date_end) - strtotime($task->date_start)) / 86400);

      array_push($response['data'], [
        'id' => $task->id,
        'title' => $task->title,
        'deadlines' => $deadline . ' дней',
        'dateStart' => $task->date_start,
        'dateEnd' => $task->date_end,
        'operatorLogin' => $task->user->email,
      ]);

      $response['tableHeader'] = [
        'Id',
        'Название',
        'Осталось времени',
        'Дата начала',
        'Дата окончания',
        'Логин оператора',
      ];
    }

    return $response;
  }
}
