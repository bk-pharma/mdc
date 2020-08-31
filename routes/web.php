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
});

Route::prefix('/sanitation')->group(function () {
    Route::get('/', 'Dashboard@sanitation')->middleware('auth');

    Route::get('/start-process', 'Dashboard@sanitationProcess');
    Route::get('/sanitized-total', 'Dashboard@getSanitizedCount');
});

Route::prefix('/manual')->group(function() {
	Route::get('/', 'Dashboard@manual')->middleware('auth');
	Route::get('/unsanitizedData', 'Dashboard@getUnsanitizedData');
	Route::get('/correctedName', 'Dashboard@getCorrectedName');
});



Route::prefix('/unclean')->group(function() {
	Route::get('/', 'Dashboard@uncleanedData')->middleware('auth');
	Route::get('/unsanitizedData', 'Dashboard@getUnsanitizedData');

});

// Route::get('/sanitize', 'Dashboard@sanitation');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
