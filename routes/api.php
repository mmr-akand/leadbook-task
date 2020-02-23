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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('user', 'Api\UserController@index');
Route::post('user', 'Api\UserController@store');
Route::get('user/{user}', 'Api\UserController@show');
Route::post('user/{user}/update-favourite', 'Api\UserController@updateFavourite');

Route::get('/company', 'Api\CompanyController@index');
Route::post('/company/search', 'Api\CompanyController@search');