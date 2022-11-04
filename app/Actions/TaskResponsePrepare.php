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
        'article' => $task->article,
        'deadlines' => $deadline . ' дней',
        'dateStart' => $task->date_start,
        'dateEnd' => $task->date_end,
        'operatorLogin' => $task->user->name,
      ]);

      $response['tableHeader'] = [
        'ID',
        'Артикул',
        'Осталось времени',
        'Дата начала',
        'Дата окончания',
        'Логин оператора',
      ];
    }

    return $response;
  }
}
