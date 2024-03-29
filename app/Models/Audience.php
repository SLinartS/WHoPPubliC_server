<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audience extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'audiences';

  public function magazines()
  {
    return $this->hasMany(Magazine::class, 'audience_id', 'id');
  }
}
