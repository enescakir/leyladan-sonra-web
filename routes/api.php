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


Route::group(['prefix' => 'admin'], function () {
    Route::get('log', 'ApiAdminController@log')->name('api.admin.logs');
    Route::get('log/{date}', 'ApiAdminController@logDaily')->name('api.admin.logs.daily');
});

Route::get('children', 'ApiController@children')->name('api.children');
Route::get('child/{id}', 'ApiController@child')->name('api.child');
Route::post('child/form', 'ApiController@childForm')->name('api.child.form');
Route::post('token', 'ApiController@token')->name('api.token');
