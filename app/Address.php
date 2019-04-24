<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';
    protected $fillable = [
        'description',
        'city_id',
    ];

    public function branchOffice() {
        return $this->hasOne(\App\BranchOffice::class);
    }
}
