<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends Model
{
    use SoftDeletes;

    protected $table = 'boxes';
    protected $fillable = [
        'code',
        'box_state_id',
    ];

    public function boxState() {
        return $this->belongsTo(\App\BoxState::class);
    }

    public function boxDetails() {
        return $this->hasMany(\App\BoxDetail::class);
    }

    public function transferDetails() {
        return $this->hasMany(\App\TransferDetail::class);
    }
}
