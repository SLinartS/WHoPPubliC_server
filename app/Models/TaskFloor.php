<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskFloor extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'tasks_floors';

    use HasFactory;

    public function points()
    {
        return $this->hasMany(Point::class, 'type_id', 'id');
    }
}
