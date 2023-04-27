<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Option;
use App\Models\Audience as ModelsAudience;

class Audience
{
  public function index()
  {
    $audiences = ModelsAudience::select('id', 'title', 'alias')->get();

    return (new Option())($audiences);
  }
}
