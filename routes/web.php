<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pDate', function () {
    $loans = App\Loan::where('status', 1)->get();
//    dd($loans);
    foreach($loans as $item) {
        $dat = \App\LoanRepayment::where('loan_id', $item->id)->max('date');
        if ($dat) {
            $date = \Carbon\Carbon::parse($dat)->format('Y-m-d');
        } else {
            $date = \Carbon\Carbon::parse($item->created_at)->format('Y-m-d');
        }
//        dd($date);
        $item->update([
            'lpDate' => $date
        ]);
    }
});

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');

// Members
    Route::get('/members', 'MemberController@index')->name('members');
    Route::get('/member/{member}', 'MemberController@member')->name('member');
    Route::get('/edit_members/{member}', 'MemberController@edit')->name('edit_member');
    Route::post('/edit_member/{member}', 'MemberController@editMember')->name('editMember');
    Route::post('/fine_member', 'MemberController@fine')->name('fine');
    Route::post('/but_util', 'MemberController@buyUtil')->name('buyUtil');
    Route::post('/searchMember', 'MemberController@searchMember')->name('searchMember');
    Route::post('/createMember', 'MemberController@createMember')->name('createMember');
    Route::get('/attendance', 'AttendanceController@index')->name('attendance');
    Route::get('/markAttendance', 'AttendanceController@markAttendance')->name('markAttendance');
    Route::post('/mark', 'AttendanceController@mark')->name('markee');

// Posts
    Route::get('/post', 'PostController@index')->name('post');
    Route::post('/postInc', 'PostController@store')->name('postInc');
    Route::post('/pmonth', 'SettingController@pmonth')->name('pmonth');

// Loans
    Route::get('/loan', 'LoanController@index')->name('loan');
    Route::post('/giveLoan', 'LoanController@store')->name('giveLoan');

// Reports
    Route::get('/monthly_analysis', 'ReportController@analysis')->name('analysis');
    Route::post('/monthly_analysis', 'ReportController@downloadAnalysis')->name('downloadAnalysis');

// Utility
    Route::get('/utility', 'UtilityController@index')->name('index');

// Settings
    Route::get('/my_profile/{member}', 'MemberController@edit')->name('my_profile');

});

Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/add_member', 'MemberController@add_member')->name('add_member');
    Route::get('/upload_member', 'MemberController@upload_member')->name('upload_member');
    Route::post('/upload_member', 'MemberController@upload')->name('upload');
    Route::post('/withdraw', 'PostController@withdraw')->name('withdraw');

    Route::post('/delete_members/', 'MemberController@destroy')->name('delete_member');
    Route::post('/perm_member/', 'MemberController@perm');
    Route::post('/restore_member/', 'MemberController@restore');
    Route::get('/deleted_members', 'MemberController@deleted')->name('deleted_members');

    //Excos (Users)
    Route::get('/excos', 'UserController@index')->name('index');
    Route::post('/remove_exco', 'UserController@remove_exco')->name('remove_exco');
    Route::post('/changePassword', 'UserController@changePassword')->name('changePassword');
    Route::post('/mkExco', 'UserController@mkExco')->name('mkExco');
    Route::post('/reLoan', 'PostController@reLoan')->name('reloan');
    Route::get('/RreLoan/{loan}', 'PostController@RreLoan')->name('rr');
    Route::post('/reSavings', 'PostController@reSavings')->name('reSavings');
    Route::post('/reShare', 'PostController@reShare')->name('reShare');
    Route::post('/reBuilding', 'PostController@reBuilding')->name('reBuilding');
    Route::get('/revokeAdmin/{user}', 'UserController@revokeAdmin')->name('revokeAdmin');
    Route::get('/makeAdmin/{user}', 'UserController@makeAdmin')->name('makeAdmin');
});
