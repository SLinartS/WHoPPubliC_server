<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfTask extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'types_of_tasks';

  public function tasks()
  {
    return $this->hasMany(Task::class, 'type_id', 'id');
  }
}
