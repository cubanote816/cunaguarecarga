<?php

use Illuminate\Http\Request;
use App\Http\Resources\ContractsCollection;
use App\Sale;
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
     Route::get('json', function () {



       // $hired_list = App\Contract::with('hired')->where('contractor', 2)->get();
       $seller_detail = Sale::where('sold_by', 9)->sum('cost');


       return ['contracts' => $seller_detail];

     });
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

        Route::post('order', 'OrderController@setOrder');

        Route::get('sellers', 'SellersController@getSellers');

        Route::get('contracts', 'ContractController@getContracts');
        Route::get('contractor', 'ContractController@getContractor');

        Route::get('reports', 'ReportController@reports');
    });

});
