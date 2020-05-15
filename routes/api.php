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

//CompanyAddresses
Route::middleware('auth:airlock')->get('/companyaddresses', 'CompanyAddressesController@index');
Route::middleware('auth:airlock')->get('/companyaddress/{id}', 'CompanyAddressesController@show');
Route::middleware('auth:airlock')->post('/companyaddresses', 'CompanyAddressesController@store');
Route::middleware('auth:airlock')->put('/companyaddress/{id}', 'CompanyAddressesController@update');
Route::middleware('auth:airlock')->delete('/companyaddress/{id}', 'CompanyAddressesController@destroy');

//Companies
Route::middleware('auth:airlock')->get('/companies', 'CompaniesController@index');
Route::middleware('auth:airlock')->get('/company/{id}', 'CompaniesController@show');
Route::middleware('auth:airlock')->post('/companies', 'CompaniesController@store');
Route::middleware('auth:airlock')->put('/company/{id}', 'CompaniesController@update');
Route::middleware('auth:airlock')->delete('/company/{id}', 'CompaniesController@destroy');