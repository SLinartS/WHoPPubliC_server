<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFloor extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'products_floors';
    
    use HasFactory;
}
