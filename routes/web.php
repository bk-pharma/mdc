<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('/sanitation')->group(function() {

	Route::get('/phase-one', 'Dashboard@phaseOne');
	Route::get('/get-all-md', 'Dashboard@getRawData');

	Route::prefix('/phase-one')->group(function() {
		Route::post('/get-single-md', 'Dashboard@getDoctorPhaseOne');
		Route::post('/get-single-md/sanitize', 'Dashboard@sanitizePhaseOne');
	});

	Route::get('/phase-two', 'Dashboard@phaseTwo');

	Route::prefix('/phase-two')->group(function() {

	});
});



// Route::get('/sanitize', 'Dashboard@sanitation');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
