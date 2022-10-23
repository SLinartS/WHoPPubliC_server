<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskPoint extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'tasks_points';
    
    use HasFactory;
}
