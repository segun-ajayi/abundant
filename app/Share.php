<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $guarded = [];

    public function history() {
        return $this->hasMany(ShareHistory::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
