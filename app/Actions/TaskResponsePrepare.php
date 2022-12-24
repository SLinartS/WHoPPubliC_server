<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TaskResponsePrepare
{

  public function __invoke(Collection $tasks)
  {
    $response = [
      'data' => [],
      'tableHeader' => []
    ];

    foreach ($tasks as $task) {

      $deadline = ((strtotime($task->date_end) - strtotime($task->date_start)) / 3600);

      array_push($response['data'], [
        'id' => $task->id,
        'article' => $task->article,
        'deadlines' => $deadline . ' часов',
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


  public function oneTask(Model $task, array $productIds, array $warehousePointIds)
  {
    $formatedTask = [];
    foreach ($task->toArray() as $key => $taskField) {
      switch ($key) {
        case "date_start":
          $formatedTask['dateStart'] = $taskField;
          break;
        case "date_end":
          $formatedTask['dateEnd'] = $taskField;
          break;
        case "user_id":
          $formatedTask['user_id'] = $taskField;
          break;
        default:
          $formatedTask[$key] = $taskField;
      }
    }

    $response = [
      'taskInfo' => $formatedTask,
      'productIds' => $productIds,
      'warehousePointIds' => $warehousePointIds,
    ];

    return $response;
  }
}
