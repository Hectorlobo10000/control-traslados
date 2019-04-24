<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSend extends Model
{
    protected $table = 'users_send';
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
