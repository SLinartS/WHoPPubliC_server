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

    public function products()
    {
        return $this->belongsToMany(Point::class, 'products_points', 'point_id', 'product_id');
    }
}
