<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoxState extends Model
{
    protected $table = 'box_states';
    protected $fillable = [
        'name',
    ];

    public function boxes() {
        return $this->hasMany(\App\Box::class);
    }
}
