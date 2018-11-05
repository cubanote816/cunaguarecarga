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

// API Group Routes
Route::group(['prefix' => 'v1'], function () {

    /*
     * Guest area
     */

    Route::post('auth/login', 'AuthController@login');
    Route::put('register/finish/{id}', 'AuthController@registerFinish');
    Route::get('register/activate/{token}', 'AuthController@registerActivate');

    /*
     * Authenticated area
     */

    Route::group(['middleware' => 'auth:api'], function () {

        Route::post('auth/register', 'AuthController@register');

        Route::get('dashboard/data', 'DashboardController@data');
        Route::get('dashboard/admin-data', 'DashboardController@adminData');

        Route::get('user/me', 'UserController@me');
        Route::resource('user', 'UserController', ['except' => ['create', 'store', 'edit']]);

    });

});
