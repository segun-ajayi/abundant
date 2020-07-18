<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $guarded = [];

    public function repayments() {
        return $this->hasMany(LoanRepayment::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
