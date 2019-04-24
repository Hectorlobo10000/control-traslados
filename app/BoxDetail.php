<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoxDetail extends Model
{
    protected $table = 'box_details';
    protected $fillable = [
        'box_id',
        'product_id',
    ];

    public function box() {
        return $this->belongsTo(\App\Box::class);
    }

    public function inventory() {
        return $this->belongsTo(\App\Inventory::class);
    }
}
