<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'products';

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }

  public function tasks()
  {
    return $this->belongsToMany(Task::class, 'products_tasks', 'product_id', 'task_id');
  }

  public function floors()
  {
    return $this->belongsToMany(Floor::class, 'products_floors', 'product_id', 'floor_id');
  }

  public function points()
  {
    return $this->belongsToMany(Point::class, 'products_points', 'product_id', 'point_id');
  }
}
