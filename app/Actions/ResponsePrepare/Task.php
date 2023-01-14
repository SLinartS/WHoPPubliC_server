<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Task
{
  public function __invoke(Collection $tasks)
  {
    $response = [
      'data' => [],
      'tableHeader' => []
    ];

    foreach ($tasks as $task) {
      $item = $this->formateTask($task);

      array_push($response['data'], $item);

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

  public function oneTask(Model $task, array $productIds, array $floorIds)
  {
    $formatedTask = $this->formateTask($task);

    $response = [
      'taskInfo' => $formatedTask,
      'productIds' => $productIds,
      // TODO заменить warehousePointIds на floorIds
      // на клиенте
      'warehousePointIds' => $floorIds,
    ];

    return $response;
  }

  private function formateTask(Model $task)
  {
    $deadline = ((strtotime($task->date_end) - strtotime($task->date_start)) / 3600);

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
      'dateStart' => [
        'value' => $task->date_start,
        'alias' => 'Дата начала'
      ],
      'dateEnd' => [
        'value' => $task->date_end,
        'alias' => 'Дата окончания'
      ],
      'operatorLogin' => [
        'value' => $task->user->name,
        'alias' => 'Логин оператора'
      ],
    ];
  }
}
