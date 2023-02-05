<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Role as ResponsePrepareRole;
use App\Models\Role as ModelsRole;

class Role
{
  public function index()
  {
    $categories = ModelsRole::select('id', 'alias')->get();

    return (new ResponsePrepareRole())($categories);
  }
}
