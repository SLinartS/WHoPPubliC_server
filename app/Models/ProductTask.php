<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTask extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'products_tasks';
    
    use HasFactory;
}
