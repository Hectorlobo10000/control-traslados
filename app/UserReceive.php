<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReceive extends Model
{
    protected $table = 'users_receive';
    protected $fillable = [
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

    public function transfer() {
        return $this->hasOne(\App\Transfer::class);
    }
}
