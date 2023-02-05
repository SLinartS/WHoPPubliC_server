<?php

namespace App\Actions\ResponsePrepare;

use Illuminate\Database\Eloquent\Collection;

class Role
{
  public function __invoke(Collection $roles)
  {
    $response = [];

    foreach ($roles as $role) {
      array_push($response, [
        'id' => $role->id,
        'title' => $role->alias,
      ]);
    }

    return $response;
  }
}
