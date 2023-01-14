<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;

class Point
{
  public function __invoke(Collection $points)
  {
    $response = [
      'acceptance' => [],
      'shipment' => [],
    ];

    foreach ($points as $point) {
      $item = [
        'id' => $point->id,
        'title' => $point->title,
      ];
      if ($point->type_id === 1) {
        array_push($response['acceptance'], $item);
      } else {
        array_push($response['shipment'], $item);
      }
    }

    return $response;
  }
}
