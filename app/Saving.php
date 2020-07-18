<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $guarded = [];

    public function history() {
        return $this->hasMany(SavingHistory::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
