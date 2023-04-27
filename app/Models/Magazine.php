<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'magazines';

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id', 'id');
  }

  public function regularity()
  {
    return $this->belongsTo(Regularity::class, 'regularity_id', 'id');
  }

  public function audience()
  {
    return $this->belongsTo(Audience::class, 'audience_id', 'id');
  }
}
