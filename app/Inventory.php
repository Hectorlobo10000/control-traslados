<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $table = 'inventories';
    protected $fillable = [
        'product_id',
        'movement_id',
        'branch_office_id',
        'balance',
    ];

    public function product() {
        return $this->belongsTo(\App\Product::class);
    }

    public function movement() {
        return $this->belongsTo(\App\Movement::class);
    }

    public function branchOffice() {
        return $this->belongsTo(\App\BranchOffice::class);
    }

    public function boxDetails() {
        return $this->hasMany(\App\BoxDetail::class);
    }
}
