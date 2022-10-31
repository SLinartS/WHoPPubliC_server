<?php

namespace App\Actions;

use Exception;
use Illuminate\Database\Eloquent\Collection;

class PointResponsePrepare
{
  public function __invoke(Collection $points)
  {
    $response = [];

    foreach ($points as $point) {
      $item = [
        'id' => $point->id,
        'title' => $point->title,
      ];
      array_push($response, $item);
    }


    return $response;
  }
}
