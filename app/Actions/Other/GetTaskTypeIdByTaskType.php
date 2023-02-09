<?php

namespace App\Actions\Other;

use App\Models\TypeOfTask as ModelsTypeOfTask;

class GetTaskTypeIdByTaskType
{
  public function __invoke(string $taskType): int
  {
    $typeOfTask = ModelsTypeOfTask::select('id')->where('type', $taskType)->first();

    return $typeOfTask->id;
  }
}
