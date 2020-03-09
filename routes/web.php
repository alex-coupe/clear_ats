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

Auth::routes();

Route::get('/candidates', function () {
    return view('candidates');
});

Route::get('/recruiters', function () {
    return view('recruiters');
});

Route::get('/dashboard', 'HomeController@index')->middleware('auth');

