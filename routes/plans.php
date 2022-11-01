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
    Route::get('calculateCalorie', 'SubscriptionController@calculateCalorie');  //api for bar 1000-1200-1500 etc
    Route::get('calculateKcal', 'SubscriptionController@calculateKcal');// api for on balance detail page -> calculte calorie in circle
    Route::post('macrosCalculator', 'SubscriptionController@macrosCalculator'); //api for calculate result page ->target calorie required in a day
    Route::post('dietPlanDetails/{diet_plan_type_id}', 'SubscriptionController@dietPlanDetails');
    Route::get('mealDetails/{meal_plan_id}', 'SubscriptionController@mealDetails');
    Route::any('targetCalorie', 'SubscriptionController@targetCalorie');
});
