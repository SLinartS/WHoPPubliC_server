<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regularity extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'regularities';
}
