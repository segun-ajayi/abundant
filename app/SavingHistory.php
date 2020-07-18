<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavingHistory extends Model
{
    protected $guarded = [];

    public function savings() {
        return $this->belongsTo(Saving::class);
    }
}
