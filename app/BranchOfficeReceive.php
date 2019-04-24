<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchOfficeReceive extends Model
{
    protected $table = 'branch_offices_receive';
    protected $fillable = [
        'branch_office_id',
    ];

    public function branchOffice() {
        return $this->belongsTo(\App\BranchOffice::class);
    }

    public function transfer() {
        return $this->hasOne(\App\Transfer::class);
    }
}
