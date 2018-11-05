<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('app');
//});
//Route::get('register/finish/{id}', 'AuthController@registerFinish');
//Route::get('register/activate/{token}', 'AuthController@registerActivate');

Route::get('{path}', function () {
    return view('app');
})->where('path', '(.*)');