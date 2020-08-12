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

Route::prefix('/sanitation')->group(function() {

	route::get('/console/get-all-md', 'Dashboard@getRawDataConsole');
	Route::get('/get-all-md', 'Dashboard@getRawData');

	Route::prefix('/phase-one')->group(function() {
		Route::get('/', 'Dashboard@phaseOne');
		Route::post('/get-single-md', 'Dashboard@getDoctorPhaseOne');
		Route::post('/get-single-md/sanitize', 'Dashboard@sanitizePhaseOne');
	});

	Route::prefix('/phase-two')->group(function() {
		Route::get('/', 'Dashboard@phaseTwo');
		Route::post('/get-single-md', 'Dashboard@getDoctorPhaseTwo');
	});

	Route::prefix('/phase-three')->group(function() {
		Route::get('/', 'Dashboard@phaseThree');
		Route::post('/get-single-md', 'Dashboard@getDoctorPhaseThree');
	});

	Route::prefix('/phase-four')->group(function() {
		Route::get('/', 'Dashboard@phaseFour');
		Route::post('/get-single-md', 'Dashboard@getDoctorPhaseFour');
	});
});

Route::prefix('/rules')->group(function() {
	Route::get('/', 'Dashboard@rules');
	Route::post('/get-single-md', 'Dashboard@getDoctorByRules');
});

Route::prefix('/name-formatter')->group(function() {
	Route::get('/', 'Dashboard@nameFormatter');
	Route::post('/get-single-md', 'Dashboard@formatName');
});


Route::prefix('/automated')->group(function() {
	Route::get('/', 'Dashboard@automated');

	Route::get('/start-process/{rowStart}/{rowCount}', 'Dashboard@sanitationProcess');
	Route::get('/sanitized-total', 'Dashboard@getSanitizedCount');
});


Route::prefix('/manual')->group(function() {
	Route::get('/', 'Dashboard@manual');
	Route::get('/unsanitizedData', 'Dashboard@getUnsanitizedData');
	Route::get('/correctedName', 'Dashboard@getCorrectedName');
});
// Route::get('/sanitize', 'Dashboard@sanitation');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
