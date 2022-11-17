<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Collection;

class PointResponsePrepare
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
        'active' => false
      ];
      if ($point->is_acceptance === 1) {
        array_push($response['acceptance'], $item);
      } else {
        array_push($response['shipment'], $item);
      }
    }

    return $response;
  }
}
