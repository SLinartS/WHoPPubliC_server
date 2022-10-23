<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'categories';

    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
