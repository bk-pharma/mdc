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

	Route::get('/get-all-md', 'Dashboard@getRawData');

	Route::prefix('/phase-one')->group(function() {
		Route::get('/', 'Dashboard@phaseOne');
		Route::post('/get-single-md', 'Dashboard@getDoctorPhaseOne');
		Route::post('/get-single-md/sanitize', 'Dashboard@sanitizePhaseOne');
	});

	Route::prefix('/phase-two')->group(function() {
		Route::get('/', 'Dashboard@phaseTwo');
		Route::post('/get-single-md', 'Dashboard@getDoctorPhaseTwo');
		Route::post('/get-single-md/sanitize', 'Dashboard@sanitizePhaseTwo');
		Route::get('/test', 'Dashboard@testPhaseTwo');
	});

	Route::prefix('/phase-three')->group(function() {
		Route::get('/', 'Dashboard@phaseThree');
		Route::post('/get-single-md', 'Dashboard@getDoctorPhaseThree');
	});

	Route::prefix('/phase-four')->group(function() {
		Route::get('/', 'Dashboard@phaseFour');
		Route::get('/test', 'Dashboard@testPhaseFour');
	});
});



// Route::get('/sanitize', 'Dashboard@sanitation');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
