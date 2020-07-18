<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Special extends Model
{
    protected $guarded = [];

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function history() {
        return $this->hasMany(SpecialHistory::class);
    }
}
