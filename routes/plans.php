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

/* Set API Lang */
\App::setlocale(!empty(request()->header('Lang')) ? request()->header('Lang') : 'en');

Route::group(['middleware' => 'auth:api','namespace' => 'Auth'], function(){    
    Route::post('subscriptionPlans', 'SubscriptionController@planListing');
    Route::get('calculateCalorie', 'SubscriptionController@calculateCalorie');  //api for bar 1000-1200-1500 etc
    Route::get('calculateKcal', 'SubscriptionController@calculateKcal');// api for on balance detail page -> calculte calorie in circle
    Route::post('macrosCalculator', 'SubscriptionController@macrosCalculator'); //api for calculate result page ->target calorie required in a day
    Route::post('dietPlanDetails/{diet_plan_type_id}', 'SubscriptionController@dietPlanDetails');
    Route::get('mealDetails/{meal_plan_id}', 'SubscriptionController@mealDetails');
    // Route::any('targetCalorie', 'SubscriptionController@targetCalorie');
    // Route::post('target_custom_calorie_save', 'SubscriptionController@target_custom_calorie_save'); 
    Route::any('targetCustomCalorieBar', 'SubscriptionController@targetCustomCalorieBar');
    Route::post('viewPlan', 'SubscriptionController@viewPlan');
    Route::post('viewPlanDeliveries', 'SubscriptionController@viewPlanDeliveries');
    Route::get('myPlan', 'SubscriptionController@myPlan');
    Route::post('buySubscriptionPlan', 'SubscriptionController@buySubscriptionPlan');


});
