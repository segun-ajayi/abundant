<?php

namespace App\Http\Controllers;

use App\Exports\MonthlyAnalysis;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function analysis() {
        return view('admin.monthlyReport');
    }


    public function downloadAnalysis(Request $request) {
        $input = $request->all();
        $validate = Validator::make($input, [
           'daterange' => 'required',
           'item' => 'required',
        ]);
        if ($validate->fails()) {
            return back(402)->with('err', 'All fields are important, Please try again.');
        }
        $date = explode(' - ', $request->daterange);
        $start = $date[0];
        $end = $date[1];
        $type = $request->type;
        $start = Carbon::parse($start . ' 00:00:00')->format('Y-m-d h:i:s');
        $end = Carbon::parse($end . ' 23:59:59')->addDay()->format('Y-m-d h:i:s');
//        return (new MonthlyAnalysis($start, $end, $type))->download('monthlyAnalysisReport.xlsx');
        $members = Member::all();

//        dd($members->where('member_id', 108)->load('loans'));
        foreach ($members as $member) {
            if ($member->savings) {
                $savingsC = $member->savings->history->whereBetween('date', [$start, $end])->sum('credit');
                $savingsD = $member->savings->history->whereBetween('date', [$start, $end])->sum('debit');
            } else {
                $savingsD = 0;
                $savingsC = 0;
            }
            if ($member->share) {
                $shareC = $member->share->history->whereBetween('date', [$start, $end])->sum('credit');
                $shareD = $member->share->history->whereBetween('date', [$start, $end])->sum('debit');
            } else {
                $shareD = 0;
                $shareC = 0;
            }
            if ($member->specialSavings) {
                $specialC = $member->specialSavings->history->whereBetween('date', [$start, $end])->sum('credit');
                $specialD = $member->specialSavings->history->whereBetween('date', [$start, $end])->sum('debit');
            } else {
                $specialD = 0;
                $specialC = 0;
            }
            if ($member->building) {
                $buildingC = $member->building->history->whereBetween('date', [$start, $end])->sum('credit');
                $buildingD = $member->building->history->whereBetween('date', [$start, $end])->sum('debit');
            } else {
                $buildingD = 0;
                $buildingC = 0;
            }
            if (!$member->loans->isEmpty()) {
                $cre = 0;
                $int = 0;
                $loan = $member->loans->where('status', 1)->first();
                if ($loan) {
                    $cre = $cre + $loan->repayments->whereBetween('date', [$start, $end])->sum('credit');
                    $int = $int + $loan->repayments->whereBetween('date', [$start, $end])->sum('interest');
                }
            } else {
                $cre = 0;
                $int = 0;
            }
            if ($member->fines) {
                $fines = $member->fines->whereBetween('date', [$start, $end])->sum('credit');
            } else {
                $fines = 0;
            }
            if ($member->utilities) {
                $util = $member->utilities->whereBetween('date', [$start, $end])->sum('amount');
            } else {
                $util = 0;
            }
            $member->savingsM = $savingsC - $savingsD;
            $member->shareM = $shareC - $shareD;
            $member->specialM = $specialC - $specialD;
            $member->buildingM = $buildingC - $buildingD;
            $member->loanRepay = $cre;
            $member->interest = $int;
            $member->fines = $fines;
            $member->util = $util;
            $member->att = $member->memberAttendance(Carbon::parse($date[1])->format('m'));
            $member->sum = $member->savingsM + $member->shareM +
                $member->fines + $member->util + $member->specialM + $member->buildingM + $member->loanRepay + $member->interest;
        }
        return view('admin.monthlyReport2', compact('members'));
    }
}
