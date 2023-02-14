<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens;
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'users';

  public function tasks()
  {
    return $this->hasMany(Task::class, 'user_id', 'id');
  }

  public function work_schedules()
  {
    return $this->hasMany(WorkSchedule::class, 'user_id', 'id');
  }

  public function authorizations_history()
  {
    return $this->hasMany(AuthorizationHistory::class, 'user_id', 'id');
  }

  public function products()
  {
    return $this->hasMany(Product::class, 'user_id', 'id');
  }

  public function role()
  {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }
}
