<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationHistory extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'location_history';
    
    use HasFactory;
}
