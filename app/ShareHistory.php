<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareHistory extends Model
{
    protected $guarded = [];

    public function share() {
        return $this->belongsTo(Share::class);
    }
}
