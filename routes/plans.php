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
    Route::get('calculateCalorie', 'SubscriptionController@calculateCalorie');
    Route::post('macrosCalculator', 'SubscriptionController@macrosCalculator');
    Route::get('dietPlanDetails/{diet_plan_type_id}', 'SubscriptionController@dietPlanDetails');
    Route::get('mealDetails/{meal_plan_id}', 'SubscriptionController@mealDetails');
});
