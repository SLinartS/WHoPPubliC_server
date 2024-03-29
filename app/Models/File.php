<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'files';

  public function type()
  {
    return $this->belongsTo(TypeOfFile::class, 'type_id', 'id');
  }
}
