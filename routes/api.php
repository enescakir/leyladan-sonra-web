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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('children', 'Front\Api\ApiController@children')->name('api.children');
Route::get('child/{id}', 'Front\Api\ApiController@child')->name('api.child');
Route::post('child/form', 'Front\Api\ApiController@childForm')->name('api.child.form');
Route::post('token', 'Front\Api\ApiController@token')->name('api.token');
