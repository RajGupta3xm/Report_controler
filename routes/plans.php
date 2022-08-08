<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Subscription Plan Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'auth:api','namespace' => 'Auth'], function(){    
    Route::post('subscriptionPlans', 'SubscriptionController@planListing');
});
