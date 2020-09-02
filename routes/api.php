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


//WHEN A USER IS LOGGED IN THESE ARE THE ROUTES THEY CAN ACCESS
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('/user', function (Request $request) {

        //return $request->user();
    	//Route::get('/user', 'UsersController@fetchUser');
    	return redirect()->action(
		    'UsersController@fetchUser', ['user' => $request->user()]
		);
    });
    //Route::get('/user', 'UsersController@fetchUser');

// INVENTORY CONTROLLER ROUTES
    Route::post('/getInventory', 'InventoryController@getInventory');
    Route::post('/searchSku', 'InventoryController@searchSku');
    Route::post('/getFilters', 'InventoryController@getFilters');
    Route::post('/getFilterData', 'InventoryController@getFilterData');
    Route::post('/testApi', 'InventoryController@testApi');

    Route::post('/sendInventory', 'InventoryController@sendInventory');

// ORDERS CONTROLLER ROUTES
    Route::post('/submitOrder', 'OrdersController@submitOrder');
    Route::post('/getOrder', 'OrdersController@getOrder');
    Route::post('/getOrders', 'OrdersController@getOrders');
    Route::post('/changeStatus', 'OrdersController@changeStatus');

// USERS CONTROLLER ROUTES
    Route::post('/getUsers', 'UsersController@getUsers');
    Route::post('/saveUser', 'UsersController@saveUser');
    Route::post('/getNeedsConfirmed', 'UsersController@getNeedsConfirmed');
    Route::post('/confirmUser', 'UsersController@confirmUser');

});


//GUEST ROUTES WILL BE PLACED HERE
Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('checkAccess', 'UsersController@checkAccess');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
