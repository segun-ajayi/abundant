<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $guarded = [];

    public function history() {
        return $this->hasMany(BuildingHistory::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
