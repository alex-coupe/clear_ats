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

Route::middleware('auth:airlock')->get('/users', 'UsersController@index');
Route::get('/user/{id}', 'UsersController@show');
Route::middleware('auth:airlock')->post('/users', 'UsersController@store');
Route::middleware('auth:airlock')->put('/user/{id}', 'UsersController@update');
Route::middleware('auth:airlock')->delete('/user/{id}', 'UsersController@destroy');


//Brands
Route::middleware('auth:airlock')->get('/brands', 'BrandsController@index');
Route::middleware('auth:airlock')->get('/brand/{id}', 'BrandsController@show');
Route::middleware('auth:airlock')->post('/brands', 'BrandsController@store');
Route::middleware('auth:airlock')->put('/brand/{id}', 'BrandsController@update');
Route::middleware('auth:airlock')->delete('/brand/{id}', 'BrandsController@destroy');
