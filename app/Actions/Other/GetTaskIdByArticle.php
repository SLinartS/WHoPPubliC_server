<?php

namespace App\Actions\Other;

use App\Models\Task as ModelsTask;

class GetTaskIdByArticle
{
  public function __invoke(string $taskArticle)
  {
    $taskId = ModelsTask::select('id')->where('article', $taskArticle)->first()->id;

    return $taskId;
  }
}
