<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Task
{
  public function __invoke(Collection $tasks)
  {
    $response = [];

    foreach ($tasks as $task) {
      $item = $this->formateTask($task);

      array_push($response, $item);
    }

    return $response;
  }

  public function oneTask(Model $task, array $productIds, array $floorIds, array $pointIds)
  {
    $formatedTask = $this->formateTask($task);

    $response = [
      'taskInfo' => $formatedTask,
      'productIds' => $productIds,
      'floorIds' => $floorIds,
      'pointIds' => $pointIds,
    ];

    return $response;
  }

  private function formateTask(Model $task)
  {
    $deadline = ((strtotime($task->time_end) - strtotime($task->time_start)) / 3600);

    return [
      'id' => [
        'value' => $task->id,
        'alias' => 'ID'
      ],
      'article' => [
        'value' => $task->article,
        'alias' => 'Артикль'
      ],
      'deadlines' => [
        'value' => $deadline . ' часов',
        'alias' => 'Осталось времени'
      ],
      'timeStart' => [
        'value' => $task->time_start,
        'alias' => 'Дата начала'
      ],
      'timeEnd' => [
        'value' => $task->time_end,
        'alias' => 'Дата окончания'
      ],
      'operatorLogin' => [
        'value' => $task->user->name,
        'alias' => 'Логин оператора'
      ],
    ];
  }
}
