<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $table = 'transfers';
    protected $fillable = [
        'transfer_state_id',
        'branch_office_send_id',
        'branch_office_receive_id',
        'user_send_id',
        'user_receive_id',
    ];

    public function transferState() {
        return $this->belongsTo(\App\TransferState);
    }

    public function branchOfficeSend() {
        return $this->belongsTo(\App\BranchOfficeSend::class);
    }

    public function branchOfficeReceive() {
        return $this->belongsTo(\App\BranchOfficeReceive::class);
    }

    public function userSend() {
        return $this->belongsTo(\App\UserSend::class);
    }

    public function userReceive() {
        return $this->belongsTo(\App\UserReceive::class);
    }

    public function transferDetails() {
        return $this->hasMany(\App\TransferDetail::class);
    }
}
