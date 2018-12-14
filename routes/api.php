<?php

use Illuminate\Http\Request;
use App\Http\Resources\ContractsCollection;
use App\Http\Resources\SellerId as SellerIdResource;
use App\Http\Resources\Role as RoleResource;
use App\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        
// foreach ($sellers as $seller) {
//     $resellers = App\Contract::with('hired')
//       ->where('contractor', $sellers->hired)
//       ->get();
//     }
      


 //        foreach($sellers as $condition){
 //          $reports->where('sold_by', 2)
 //            ->orderBy('created_at', 'desc');


 // $user = App\User::find($condition->hired);
      
 //      $role = new RoleResource($user);

 //          $tt = $role->role;

 //          if($tt == 'reseller'){
 //            $resellers = App\Contract::with('hired')
 //      ->where('contractor', $condition->hired)
 //      ->get();
 //            $test = (new App\Sale)->newQuery();
 //            foreach($resellers as $conditionSeller){
 //              $test->where(function ($query) use($conditionSeller) {
 //                  $query->where('sold_by', '=', $conditionSeller['hired'])
 //                ->orwhere('sold_by', $conditionSeller['contractor']);
 //              });

 //              // $temp += $test->get();
 //            }
 //            $temp = $test->get();
 //          }          
 //        } 

 //        $reseller = $reports->get(); //obtengo resulatod de reseller
 //        $result = $reports->merge($test);




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
        Route::get('dashboard/sales-last-30-days', 'DashboardController@salesLast30Days');


        Route::get('user/me', 'UserController@me');
        Route::post('user/status', 'UserController@status');
        Route::resource('user', 'UserController', ['except' => ['create', 'store', 'edit']]);

        Route::post('order', 'OrderController@setOrder');

        Route::get('sellers', 'SellersController@getSellers');
        Route::post('seller/detail', 'SellersController@getSellerDetail');
        Route::get('loadsellers', 'SellersController@getSellerList');
        Route::get('loadsellersnumber', 'SellersController@getSellerNumber');

        Route::get('contracts', 'ContractController@getContracts');
        Route::get('contractor', 'ContractController@getContractor');
        Route::post('contract/agreement', 'ContractController@updateAgreement');

        Route::get('reports', 'ReportController@reports');
        Route::get('history', 'ReportController@history');

        Route::get('last20sales', 'ReportController@last20');
        Route::get('salesstatus', 'ReportController@salesStatus');
        Route::get('statistic', 'ReportController@sales');
        Route::get('pay', 'ReportController@pay');

    });

});
