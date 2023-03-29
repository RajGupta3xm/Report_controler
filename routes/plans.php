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
    Route::post('subscriptionPlans', 'SubscriptionController@planListing');  // this API is not anywhere
    Route::get('calculateCalorie', 'SubscriptionController@calculateCalorie');  //api for bar 1000-1200-1500 etc
    Route::get('calculateKcal', 'SubscriptionController@calculateKcal');// api for on balance detail page -> calculte calorie in circle
    Route::post('macrosCalculator', 'SubscriptionController@macrosCalculator'); //api for calculate result page ->target calorie required in a day
    Route::post('dietPlanDetails/{diet_plan_type_id}', 'SubscriptionController@dietPlanDetails');
    Route::get('mealDetails/{meal_plan_id}', 'SubscriptionController@mealDetails');
    Route::any('targetCalorie', 'SubscriptionController@targetCalorie');
    // Route::post('target_custom_calorie_save', 'SubscriptionController@target_custom_calorie_save'); 
    Route::any('targetCustomCalorieBar', 'SubscriptionController@targetCustomCalorieBar');
    Route::post('viewPlan', 'SubscriptionController@viewPlan');
    Route::post('viewPlanDeliveries', 'SubscriptionController@viewPlanDeliveries');
    Route::get('myPlan', 'SubscriptionController@myPlan');
    Route::post('buySubscriptionPlan', 'SubscriptionController@buySubscriptionPlan');
    Route::post('sample_daily_meals_with_schedule', 'SubscriptionController@sample_daily_meals_with_schedule'); 
    Route::get('selectStartDayCircle', 'SubscriptionController@selectStartDayCircle');
    Route::get('paymentPlan_detail/{plan_id}/{variant_id}', 'SubscriptionController@paymentPlan_detail');
    Route::post('getSwapMeal', 'SubscriptionController@getSwapMeal');
    Route::post('apply_gift_card', 'SubscriptionController@apply_gift_card');
    Route::post('apply_promo_code', 'SubscriptionController@apply_promo_code');
    Route::post('apply_referral_code', 'SubscriptionController@apply_referral_code');
    Route::get('getArea', 'SubscriptionController@getArea');
    Route::post('myMeals', 'SubscriptionController@myMeals');
    Route::post('changeDeliveryTime', 'SubscriptionController@changeDeliveryTime');
    Route::post('userSkipDelivery', 'SubscriptionController@userSkipDelivery');
    Route::post('userChangeDeliveryLocation','SubscriptionController@userChangeDeliveryLocation');
    Route::post('switchPlan','SubscriptionController@switchPlan');
    Route::post('swapMeal','SubscriptionController@swapMeal');
    Route::get('savedAddressListing', 'SubscriptionController@savedAddressListing');
    Route::post('pause_meal_plan', 'SubscriptionController@pause_meal_plan');
    Route::post('viewPreviousPlan', 'SubscriptionController@viewPreviousPlan');
    Route::post('viewPreviousPlanDeliveries', 'SubscriptionController@viewPreviousPlanDeliveries');
    Route::post('repeat_meal_plan', 'SubscriptionController@repeat_meal_plan');
    Route::post('userUnskipDelivery', 'SubscriptionController@userUnskipDelivery');
    Route::post('updateDateForSelectStartDateAndMeal', 'SubscriptionController@updateDateForSelectStartDateAndMeal');
    Route::post('saveRecommendedCalorie', 'SubscriptionController@saveRecommendedCalorie');
    Route::post('swapMeallisting', 'SubscriptionController@swapMeallisting'); 
    
});
