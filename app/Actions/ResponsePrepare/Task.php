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
    $formattedTask = $this->formateTask($task);
    $formattedFloorInfo = $this->formateFloorInfo($floorInfo);

    $response = [
      'taskInfo' => $formattedTask,
      'productIds' => $productIds,
      'floorInfo' => $formattedFloorInfo,
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
        'value' => $this->formateTaskTime($task->time_end),
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
    $formattedFloors = [];

    foreach ($floors as $floor) {
      $floorIndex = array_search($floor->floor_id, array_column($formattedFloors, 'floorId'), true);
      if ($floorIndex !== false) {
        $formattedFloors[$floorIndex]['occupiedSpace'] += $floor->occupied_space;
      } else {
        array_push(
          $formattedFloors,
          [
            'floorId' => $floor->floor_id,
            'occupiedSpace' => $floor->occupied_space
          ]
        );
      }
    }

    return $formattedFloors;
  }

  private function formateTaskTime(string $time)
  {
    $dateTime = strtotime($time);
    $formattedTime = date('d.m.Y H:i', $dateTime);
    return $formattedTime;
  }
}
