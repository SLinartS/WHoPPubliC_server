<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'points';

  public function products()
  {
    return $this->belongsToMany(Point::class, 'products_points', 'point_id', 'product_id');
  }

  public function type()
  {
    return $this->belongsTo(TypeOfPoint::class, 'type_id', 'id');
  }
}
