<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $hidden = ['pivot'];

  protected $table = 'sections';

  public function blocks()
  {
    return $this->hasMany(Block::class, 'section_id', 'id');
  }

  public function zone()
  {
    return $this->belongsTo(Zone::class, 'zone_id', 'id');
  }
}
