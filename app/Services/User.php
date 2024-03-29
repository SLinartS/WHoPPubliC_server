<?php

namespace App\Services;

use App\Actions\ResponsePrepare\User as ResponsePrepareUser;
use App\Models\AuthorizationHistory;
use App\Models\Role as ModelsRole;
use App\Models\User as ModelsUser;
use App\Models\WorkSchedule as ModelsWorkSchedule;
use Illuminate\Support\Facades\Hash;

class User
{
  public function index(string | null $search)
  {
    $users = ModelsUser::select('id', 'email', 'phone', 'login', 'name', 'surname', 'patronymic', 'role_id', 'is_del')
      ->addSelect(['role' => ModelsRole::select('title')->whereColumn('id', 'role_id')])
      ->where('is_del', false);


    if ($search) {
      $searchField = '%' . $search . '%';
      $users = $users->where('email', 'like', $searchField)
        ->orWhere('phone', 'like', $searchField)
        ->orWhere('login', 'like', $searchField)
        ->orWhere('name', 'like', $searchField)
        ->orWhere('surname', 'like', $searchField)
        ->orWhere('patronymic', 'like', $searchField)
        ->get();
    } else {
      $users = $users->get();
    }

    return (new ResponsePrepareUser())($users);
  }

  public function show(int $id)
  {
    $user = ModelsUser::select('id', 'email', 'phone', 'login', 'name', 'surname', 'patronymic', 'role_id')
      ->addSelect(['role' => ModelsRole::select('title')->whereColumn('id', 'role_id')])
      ->where('id', $id)
      ->first();

    return (new ResponsePrepareUser())->one($user);
  }

  public function store(
    array $fields,
    array $workSchedules,
  ) {
    $user = new ModelsUser();
    $user->email = $fields['email']['value'];
    $user->phone = $fields['phone']['value'];
    $user->login = $fields['login']['value'];
    $user->password = Hash::make($fields['password']['value']);
    $user->name = $fields['name']['value'];
    $user->surname = $fields['surname']['value'];
    $user->patronymic = $fields['patronymic']['value'];
    $user->role_id = $fields['roleId']['value'];
    $user->is_del = false;

    $user->save();

    foreach ($workSchedules as $indexDayOfWeek => $workSchedule) {
      $schedule = new ModelsWorkSchedule();
      $schedule->start_time = $workSchedule['startTime']['value'];
      $schedule->end_time = $workSchedule['endTime']['value'];
      $schedule->day_of_week = $indexDayOfWeek;
      $schedule->user_id = $user->id;
      $schedule->save();
    }
  }

  public function update(
    array $fields,
    array $workSchedules,
  ) {
    $id = $fields['id']['value'];

    $user = ModelsUser::where('id', $id)->first();
    $user->email = $fields['email']['value'];
    $user->phone = $fields['phone']['value'];
    $user->login = $fields['login']['value'];
    if (strlen($fields['password']['value']) > 0) {
      $user->password = $fields['password']['value'];
    }
    $user->name = $fields['name']['value'];
    $user->surname = $fields['surname']['value'];
    $user->patronymic = $fields['patronymic']['value'];
    $user->role_id = $fields['roleId']['value'];
    $user->is_del = false;

    $user->save();

    foreach ($workSchedules as $indexDayOfWeek => $workSchedule) {
      $schedule = ModelsWorkSchedule::where('user_id', $id)
        ->where('day_of_week', $indexDayOfWeek)
        ->first();
      $schedule->start_time = $workSchedule['startTime']['value'];
      $schedule->end_time = $workSchedule['endTime']['value'];
      $schedule->save();
    }
  }

  public function destroy(int $id)
  {
    ModelsWorkSchedule::where('user_id', $id)->delete();
    AuthorizationHistory::where('user_id', $id)->delete();
    $user = ModelsUser::where('id', $id)->first();
    $user->is_del = true;
    $user->save();
  }
}
