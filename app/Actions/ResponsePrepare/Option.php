<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;

class Option
{
  public function __invoke(Collection $options)
  {
    $response = [];

    foreach ($options as $option) {
      array_push($response, [
        'id' => $option->id,
        'title' => $option->title,
        'alias' => $option->alias,
      ]);
    }

    return $response;
  }
}
