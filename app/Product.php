<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'code',
        'description',
        'enable',
    ];

    public function inventories() {
        return $this->hasMany(\App\Invetory::class);
    }
}
