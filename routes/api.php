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

//recruiters
Route::middleware('auth:airlock')->get('/recruiters', 'RecruitersController@index');
Route::get('/recruiter/{id}', 'RecruitersController@show');
Route::middleware('auth:airlock')->post('/recruiters', 'RecruitersController@store');
Route::middleware('auth:airlock')->put('/recruiter/{id}', 'RecruitersController@update');
Route::middleware('auth:airlock')->delete('/recruiter/{id}', 'RecruitersController@destroy');

//Locations
Route::middleware('auth:airlock')->get('/locations', 'LocationsController@index');
Route::middleware('auth:airlock')->get('/location/{id}', 'LocationsController@show');
Route::middleware('auth:airlock')->post('/locations', 'LocationsController@store');
Route::middleware('auth:airlock')->put('/location/{id}', 'LocationsController@update');
Route::middleware('auth:airlock')->delete('/location/{id}', 'LocationsController@destroy');

//Companies
Route::middleware('auth:airlock')->get('/companies', 'CompaniesController@index');
Route::middleware('auth:airlock')->get('/company/{id}', 'CompaniesController@show');
Route::middleware('auth:airlock')->post('/companies', 'CompaniesController@store');
Route::middleware('auth:airlock')->put('/company/{id}', 'CompaniesController@update');
Route::middleware('auth:airlock')->delete('/company/{id}', 'CompaniesController@destroy');