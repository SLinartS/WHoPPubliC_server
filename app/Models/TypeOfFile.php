<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfFile extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'types_of_files';

  public function files()
  {
    return $this->hasMany(File::class, 'type_id', 'id');
  }
}
