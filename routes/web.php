<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard;

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


Route::get('/admin', function () {
    return view('layouts.admin');
});

Route::prefix('/raw-data')->group(function () {
    Route::get('/all', 'Dashboard@getAllRawData');
});

Route::prefix('/import')->group(function () {
    Route::get('/', 'Dashboard@import');
    Route::post('/start', 'Dashboard@importNow');
    Route::post('/progress','Dashboard@importProgress');
    Route::get('/errors', 'Dashboard@getImportErrors');
    Route::get('/errors/export', 'Dashboard@exportImportErrors');
});

Route::prefix('/sanitation')->group(function () {
    Route::get('/', 'Dashboard@sanitation')->middleware('auth');

    Route::get('/start-process', 'Dashboard@sanitationProcess');
    Route::get('/sanitized-total', 'Dashboard@getSanitizedCount');
});


Route::get('/mdc/manual/sanitation', 'ManualSanitationController@getManualSanitation');

Route::get('/sanitation/data', 'ManualSanitationController@getSanitationData');

Route::get('/get/rules_by/{mdCode}', 'ManualSanitationController@getByMdCode'); //GAWA NI JHAY TO RETRIEVE MD BY mdcode

Route::post('/set/rules_by', 'ManualSanitationController@updateMdByMdCode')->name('set.rules_by'); // gawa ni jhay to update md by raw_id and mdcode

Route::get('/get/rule_code/{ruleCode}', 'ManualSanitationController@getByRawIds'); // gawa ni jhay to update md by raw_id and mdcode

Route::get('/get/rawDoctors', 'ManualSanitationController@updateRawDoctors');

Route::post('/realtime/sanitation', 'ManualSanitationController@postRealtimeSanitationData')->name('manual.sanitation');

Route::post('/realtime/check/all/rows', 'ManualSanitationController@postRealtimeCheckAllRows')->name('check.all.rows');

Route::post('/set/rules/sanitize', 'ManualSanitationController@postSetRuleSanitize')->name('set.rules.sanitize');

Route::post('/set/rules/sanitize/one', 'ManualSanitationController@postSetRuleSanitizeOne')->name('set.rules.sanitize.one');

Route::post('/rules/sanitation', 'ManualSanitationController@rulesToBeCreated')->name('rules.sanitaion'); //gawa ni norman naka dd lang naman

Route::post('/mark/all/as/unidentifed', 'ManualSanitationController@postMarkAllUnidentified');


Route::get('/get/selected', 'ManualSanitationController@getSelected');

Route::get('/admin', function () {
    return view('layouts.admin');
});

Route::get('/csrf', function(){
	return csrf_token();
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
