<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizationHistory extends Model
{
    public $timestamps = false;
    protected $hidden = ['pivot'];

    protected $table = 'authorization_history';

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
