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

  public function oneTask(Model $task, array $productIds, Collection $floorInfo, array $pointIds)
  {
    $formatedTask = $this->formateTask($task);
    $formatedFloorInfo = $this->formateFloorInfo($floorInfo);

    $response = [
      'taskInfo' => $formatedTask,
      'productIds' => $productIds,
      'floorInfo' => $formatedFloorInfo,
      'pointIds' => $pointIds,
    ];

    return $response;
  }

  private function formateTask(Model $task)
  {
    $deadline = round(((strtotime($task->time_end) - strtotime($task->time_start)) / 3600));

    return [
      'id' => [
        'value' => $task->id,
        'alias' => 'ID'
      ],
      'article' => [
        'value' => $task->article,
        'alias' => 'Артикул'
      ],
      'deadlines' => [
        'value' => $deadline . ' часов',
        'alias' => 'Осталось времени'
      ],
      'timeStart' => [
        'value' => $this->formateTaskTime($task->time_start),
        'alias' => 'Дата начала'
      ],
      'timeEnd' => [
        'value' =>$this->formateTaskTime($task->time_end),
        'alias' => 'Дата окончания'
      ],
      'operatorLogin' => [
        'value' => $task->user->login,
        'alias' => 'Логин оператора'
      ],
    ];
  }

  private function formateFloorInfo(Collection $floors): array
  {
    $formatedFloors = [];

    foreach ($floors as $floor) {
      $floorIndex = array_search($floor->floor_id, array_column($formatedFloors, 'floorId'), true);
      if ($floorIndex !== false) {
        $formatedFloors[$floorIndex]['occupiedSpace'] += $floor->occupied_space;
      } else {
        array_push(
          $formatedFloors,
          [
            'floorId' => $floor->floor_id,
            'occupiedSpace' => $floor->occupied_space
          ]
        );
      }
    }

    return $formatedFloors;
  }

  private function formateTaskTime(string $time)
  {
    $dateTime = strtotime($time);
    $formatedTime = date('d.m.Y H:i', $dateTime);
    return $formatedTime;
  }
}
