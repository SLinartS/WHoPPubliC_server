<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Option;
use App\Models\Regularity as ModelsRegularity;

class Regularity
{
  public function index()
  {
    $regularities = ModelsRegularity::select('id', 'title', 'alias')->get();

    return (new Option())($regularities);
  }
}
