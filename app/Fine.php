<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    protected $guarded = [];

    public function member() {
        return $this->belongsToMany(Member::class);
    }
}
