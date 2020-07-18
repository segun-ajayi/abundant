<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Member extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = [];


    public function share() {
        return $this->hasOne(Share::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function isAdmin() {
        if ($this->user_id) {
            $user = User::find($this->user_id);
//            dd($user->role);
            if($user->role == 'user') {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function attendance() {
        return $this->belongsToMany(Attendance::class);
    }

    public function savings() {
        return $this->hasOne(Saving::class);
    }

    public function specialSavings() {
        return $this->hasOne(Special::class);
    }

    public function fines() {
        return $this->belongsToMany(Fine::class);
    }

    public function building() {
        return $this->hasOne(Building::class);
    }

    public function loans() {
        return $this->hasMany(Loan::class);
    }

    public function utilities() {
        return $this->hasMany(Utility::class);
    }

    public function getLoan() {
        $loan = $this->loans()->where('status', 1)->get();
        if ($loan->isEmpty()) {
            return 0;
        }
        return $loan[0]->balance;
    }

    public function getLastPay() {
        $loan = $this->loans()->where('status', 1)->get();
        if ($loan->isEmpty()) {
            return 0;
        }
        $last = Carbon::parse($loan[0]->lpDate)->format('m');
        $now = Carbon::parse(Setting::find(1)->pDate)->format('m');
        $lp = $now - $last;
        if ($lp < 0) {
            $lp = $lp + 12;
        }
        return $lp;
    }

    public function getSavingH() {
        $sh = $this->savings;
        if (!$sh) {
            return collect([]);
        }
        return $sh->history->sortByDesc('created_at')->take(5);
    }

    public function getShareH() {
        $sh = $this->share;
        if (!$sh) {
            return collect([]);
        }
        return $sh->history->sortByDesc('created_at')->take(5);
    }

    public function getBuildingH() {
        $sh = $this->building;
        if (!$sh) {
            return collect([]);
        }
        return $sh->history->sortByDesc('created_at')->take(5);
    }

    public function hasActiveLoan() {
        $sh = $this->loans()->where('status', 1)->first();
        return $sh;
    }

    public function getLoanH() {
        $sh = $this->loans()->where('status', 1)->get();
        if ($sh->isEmpty()) {
            return collect([]);
        }
        return $sh[0]->repayments->sortByDesc('created_at')->take(5);
    }

    public function getSaving() {
        $savings = $this->savings;
        return $savings ? $savings->balance : 0;
    }

    public function getsSaving() {
        $savings = $this->specialSavings;
        return $savings ? $savings->balance : 0;
    }

    public function getShare() {
        $share = $this->share;
        return $share ? $share->balance : 0;
    }

    public function getBuilding() {
        $building = $this->building;
        return $building ? $building->balance : 0;
    }

    public function loanPercent() {
        $loan = $this->loans()->where('status', 1)->get();
        return (($loan[0]->amount - $loan[0]->balance) / $loan[0]->amount) *100;
    }

    public function sharePercent() {
        $share = $this->share();
        if ($share->exists()) {
            $per = ($this->share->balance / 15000) * 100;
        } else {
            $per = 0;
        }
        return $per;
    }

    public function creditSavings($saving, $mode) {
        $savings = $this->savings();
        if ($savings->doesntExist()) {
            $this->savings()->create([
               'balance' => 0
            ]);
        }
        $savings = $this->savings;
        $savings->balance = $savings->balance + $saving;
        $savings->save();
        $savings->history()->create([
        'date' => Setting::find(1)->pDate,
        'credit' => $saving,
        'mode' => $mode,
        'entered_by' => Auth::id()
        ]);
    }

    public function debitSavings($saving, $mode) {
        $savings = $this->savings();
        if ($savings->doesntExist()) {
            $this->savings()->create([
               'balance' => 0
            ]);
        }
        $savings = $this->savings;
        $savings->balance = $savings->balance - $saving;
        $savings->save();
        $savings->history()->create([
        'date' => Setting::find(1)->pDate,
        'debit' => $saving,
        'mode' => $mode,
        'entered_by' => Auth::id()
        ]);
    }

    public function creditSpecial($saving, $mode) {
        $spe = $this->specialSavings();
        if ($spe->doesntExist()) {
            $this->specialSavings()->create([
               'balance' => 0
            ]);
        }
        $spe = $this->specialSavings;
        $spe->balance = $spe->balance + $saving;
        $spe->save();
        $spe->history()->create([
        'date' => Setting::find(1)->pDate,
        'credit' => $saving,
        'mode' => $mode,
        'entered_by' => Auth::id()
        ]);
    }

    public function debitSpecial($saving, $mode) {
        $spe = $this->specialSavings();
        if ($spe->doesntExist()) {
            $this->specialSavings()->create([
               'balance' => 0
            ]);
        }
        $spe = $this->specialSavings;
        $spe->balance = $spe->balance - $saving;
        $spe->save();
        $spe->history()->create([
        'date' => Setting::find(1)->pDate,
        'debit' => $saving,
        'mode' => $mode,
        'entered_by' => Auth::id()
        ]);
    }

    public function creditBuilding($build, $mode) {
        $builds = $this->building();
        if ($builds->doesntExist()) {
            $this->building()->create([
                'balance' => 0
            ]);
        }
        $builds = $this->building;
        $builds->balance = $builds->balance + $build;
        $builds->save();
        $builds->history()->create([
        'date' => Setting::find(1)->pDate,
        'credit' => $build,
        'mode' => $mode,
        'entered_by' => Auth::id()
        ]);
    }

    public function creditShare($share, $mode) {
        $shares = $this->share();
        if ($shares->doesntExist()) {
            $this->share()->create([
                'balance' => 0
            ]);
        }
        $shares = $this->share;
        $shares->balance = $shares->balance + $share;
        $shares->save();
        $shares->history()->create([
        'date' => Setting::find(1)->pDate,
        'credit' => $share,
        'mode' => $mode,
        'entered_by' => Auth::id()
        ]);
    }

    public function debitShare($saving, $mode) {
        $spe = $this->share();
        if ($spe->doesntExist()) {
            $this->share()->create([
                'balance' => 0
            ]);
        }
        $spe = $this->share;
        $spe->balance = $spe->balance - $saving;
        $spe->save();
        $spe->history()->create([
            'date' => Setting::find(1)->pDate,
            'debit' => $saving,
            'mode' => $mode,
            'entered_by' => Auth::id()
        ]);
    }

    public function creditLoan($loan, $interest, $mode) {
        $loans = $this->loans()->where('status', 1)->get();
        if ($loans->isEmpty()) {
            return;
        }
        $loans[0]->balance = $loans[0]->balance - $loan;
        $loans[0]->lpDate = Setting::find(1)->pDate;
        $loans[0]->save();
        $loans = $this->loans()->where('status', 1)->get();
        if ($loans[0]->balance < 1) {
            $loans[0]->status = 0;
            $loans[0]->save();
        }
        $loans[0]->repayments()->create([
            'date' => Setting::find(1)->pDate,
            'credit' => $loan,
            'interest' => $interest,
            'mode' => $mode,
            'entered_by' => Auth::id()
        ]);
    }

    public function memberAttendance($mon) {
        $att = $this->attendance->where('month', '<=', $mon)->count();
        $per = ($att/$mon) * 100;
        return $per;
    }
}
