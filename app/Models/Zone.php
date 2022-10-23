<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'zones';
    
    use HasFactory;

    public function sections()
    {
        return $this->hasMany(Section::class, 'zone_id', 'id');
    }
}
