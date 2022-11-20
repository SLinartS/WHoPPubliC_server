<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPoint extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'products_points';

    use HasFactory;

}
