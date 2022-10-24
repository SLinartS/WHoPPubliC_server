<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'task_types';

    use HasFactory;

    public function tasks()
    {
        return $this->hasMany(Task::class, 'task_type_id', 'id');
    }
}
