<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group and prefix versioning. Enjoy building your API!
|
*/


/**
 * This is the v1 version of the api for laravel-angular admin (Guest)
 */

Route::group(['prefix' => 'v1'], function () {

    Route::post('login', 'Api\v1\LoginController@login');
    Route::post('logout', 'Api\v1\LoginController@logout');
    Route::post('register', 'Api\v1\RegisterController@register');
});

/**
 * This is the v1 version of the api for laravel-angular admin (Authorized)
 */
Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function() {

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    route::resource('clients', 'Api\v1\ClientController');
});
