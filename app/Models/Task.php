<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'tasks';

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function type()
  {
    return $this->belongsTo(TypeOfTask::class, 'type_id', 'id');
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, 'products_tasks', 'task_id', 'product_id');
  }

  public function floors()
  {
    return $this->belongsToMany(Floor::class, 'tasks_floors', 'task_id', 'floor_id');
  }
}
