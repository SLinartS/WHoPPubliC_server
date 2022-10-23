<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'points';
    
    use HasFactory;
}
