<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialHistory extends Model
{
    protected $guarded = [];

    public function special() {
        return $this->belongsTo(Special::class);
    }
}
