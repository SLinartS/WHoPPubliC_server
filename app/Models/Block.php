<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'blocks';

  public function floors()
  {
    return $this->hasMany(Floor::class, 'block_id', 'id');
  }

  public function section()
  {
    return $this->belongsTo(Section::class, 'section_id', 'id');
  }
}
