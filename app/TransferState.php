<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferState extends Model
{
    protected $table = 'transfer_states';
    protected $fillable = [
        'name',
    ];

    public function transfers() {
        return $this->hasMany(\App\Transfer::class);
    }
}
