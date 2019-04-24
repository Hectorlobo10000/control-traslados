<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    protected $table = 'transfer_details';
    protected $fillable = [
        'transfer_id',
        'box_id',
    ];

    public function box() {
        return $this->belongsTo(\App\Box::class);
    }

    public function transfer() {
        return $this->belongsTo(\App\Transfer::class);
    }
}
