<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Option;
use App\Models\Role as ModelsRole;

class Role
{
  public function index()
  {
    $roles = ModelsRole::select('id', 'title', 'alias')->get();

    return (new Option())($roles);
  }
}
