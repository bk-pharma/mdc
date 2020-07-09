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

Route::get('/test', function() {
    $data = App\User::all();
    return json_encode($data);
});


Route::prefix('/dashboard')->group(function() {
	Route::get('/', 'Dashboard@index');
});


Route::prefix('/sanitation')->group(function() {
	Route::get('/', 'Dashboard@sanitation');
	Route::get('/first-list-md', 'Dashboard@getFirstListMD');

	Route::post('/md', 'Dashboard@getDoctorByName');
});

// Route::get('/sanitize', 'Dashboard@sanitation');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
