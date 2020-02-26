<?php

use Illuminate\Http\Request;

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

Route::post('/login', 'Api\AuthController@login');
Route::post('register', 'Api\UserController@store');

Route::group(['middleware' => ['auth:api']], function() {
	Route::get('user', 'Api\UserController@index');
	Route::get('user/{user}', 'Api\UserController@show');
	Route::get('user/{user}/favourite', 'Api\UserController@favourite');
	Route::post('user/{user}/update-favourite', 'Api\UserController@updateFavourite');

	Route::get('/company', 'Api\CompanyController@index');
	Route::post('/company/search', 'Api\CompanyController@search');
	Route::post('/logout',  'Api\AuthController@logout');
});