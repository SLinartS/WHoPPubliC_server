<?php

namespace App\Services;

use App\Actions\ResponsePrepare\Account as ResponsePrepareAccount;
use App\Models\Role as ModelsRole;
use App\Models\User as ModelsUser;

class Account
{
  public function index()
  {
    $users = ModelsUser::select('id', 'email', 'phone','name', 'surname', 'patronymic', 'role_id')
    ->addSelect(['role' => ModelsRole::select('title')->whereColumn('id', 'role_id')])
    ->get();

    return (new ResponsePrepareAccount())($users);
  }
}
