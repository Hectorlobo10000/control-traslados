<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchOffice extends Model
{

    use SoftDeletes;

    protected $table = 'branch_offices';
    protected $fillable = [
        'name',
        'abbreviation',
        'address_id',
    ];

    public function address() {
        return $this->belongsTo(\App\Address::class);
    }

    public function users() {
        return $this->hasMany(\App\User::class);
    }

    public function branchOfficesSend() {
        return $this->hasMany(\App\BranchOfficeSend::class);
    }

    public function branchOfficesReceive() {
        return $this->hasMany(\App\BranchOfficeReceive::class);
    }

    public function inventories() {
        return $this->hasMany(\App\Invetory::class);
    }
}
