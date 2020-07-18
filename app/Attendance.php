<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [];
    protected $with = ['members'];

    public function members() {
        return $this->belongsToMany(Member::class);
    }

    public function markAttendance($mark, $member) {
        if ($mark == 'true') {
            $this->members()->attach($member);
        } else {
            $this->members()->detach($member);
        }
    }
}
