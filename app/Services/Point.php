<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Point as ResponsePreparePoint;
use App\Models\Point as ModelsPoint;

class Point
{
  public function index()
  {
    $points = ModelsPoint::select('id', 'title', 'type_id')->get();

    return (new ResponsePreparePoint())($points);
  }
}
