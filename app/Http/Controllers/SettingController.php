<?php

namespace App\Http\Controllers;

use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function pmonth(Request $request) {
        $month = $request->pMonth;
        $date = Carbon::now()->year . '/' . $month . '/16';
        Setting::updateOrCreate(['id' => 1], [
            'pDate' => carbon::parse($date)->format('Y-m-d')
        ]);
        return response([
            'message' => 'Month Changed successfully',
            'status' => 1
        ]);
    }
}
