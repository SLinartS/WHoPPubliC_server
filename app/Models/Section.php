<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'sections';
    
    use HasFactory;
}
