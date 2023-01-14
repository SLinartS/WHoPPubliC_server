<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'floors';

  public function locations()
  {
    return $this->hasMany(LocationHistory::class, 'floor_id', 'id');
  }

  public function block()
  {
    return $this->belongsTo(Block::class, 'block_id', 'id');
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, 'products_floors', 'floor_id', 'product_id');
  }

  public function tasks()
  {
    return $this->belongsToMany(Product::class, 'tasks_floors', 'floor_id', 'task_id');
  }
}
