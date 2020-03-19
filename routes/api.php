<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Users
Route::middleware('auth:airlock')->get('/users', 'UsersController@index');
Route::middleware('auth:airlock')->get('/user/{id}', 'UsersController@show');
Route::middleware('auth:airlock')->post('/users', 'UsersController@store');
Route::middleware('auth:airlock')->put('/user/{id}', 'UsersController@update');
Route::middleware('auth:airlock')->delete('/user/{id}', 'UsersController@destroy');

//Locations
Route::middleware('auth:airlock')->get('/locations', 'LocationsController@index');
Route::middleware('auth:airlock')->get('/location/{id}', 'LocationsController@show');
