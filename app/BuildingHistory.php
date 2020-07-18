<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingHistory extends Model
{
    protected $guarded = [];

    public function building() {
        return $this->belongsTo(Building::class);
    }
}
