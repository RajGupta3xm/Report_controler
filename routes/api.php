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

/* Set API Lang */
// \App::setlocale(!empty(request()->hasHeader('X-localization')) ? request()->header('X-localization') : 'en');

// Route::get('greeting', 'Auth\ApiController@lang')
//       ->middleware('localization');

// Route::get('/aboutUss', function (Request $request) {
//     \App::setlocale(!empty($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en');
//     $lang = (($request->hasHeader('X-localization')) ? $request->header('X-localization') : 'en');
//     User::where('id',Auth::guard('api')->id())->update(['lang'=>$lang]);
//     // echo $lang;
//     // die;
// });


Route::post('/registerUser','Auth\ApiController@register');
Route::post('/verifyOtp','Auth\ApiController@verifyOtp');
Route::post('/login','Auth\ApiController@login');
Route::post('resendOTP', 'Auth\ApiController@resendOTP');

Route::get('/countryList','Auth\ApiController@countryList');
Route::get('/getLogout', 'Auth\ApiController@getLogout');
Route::get('/authfail', 'Controller@authfail');
Route::post('/helpSupport','Auth\ApiController@helpSupport');
Route::get('/aboutUs','Auth\ApiController@aboutUs');
Route::get('/privacyPolicy','Auth\ApiController@privacyPolicy');
Route::get('/privacyPolicyWeb','Auth\ApiController@privacyPolicyWeb');
Route::get('/termsConditions','Auth\ApiController@termsConditions');
Route::get('/onboardingScreen','Auth\ApiController@onboardingScreen');

Route::post('insertImage', 'Auth\ApiController@insertImage');


/*********Driver route */
// Route::post('/driver/login','Auth\DriverController@login');
/********End Driver Route */

Route::group(['middleware' => 'auth:api','namespace' => 'Auth'], function(){	
  
    Route::get('/setLang', 'ApiController@setLang');
	Route::get('myProfile', 'ApiController@myProfile');
	Route::post('/editProfile','ApiController@editProfile');
    Route::any('/homescreen/{plan_types}','ApiController@homescreen');
    Route::get('/fitnessGoals','ApiController@fitnessGoals');
    Route::get('/dislikes','ApiController@dislikes');
    Route::get('/dietPlanType','ApiController@dietPlanType');
    Route::post('/updatePersonalDetails','ApiController@updatePersonalDetails');
    Route::post('/updateFitnessDetails','ApiController@updateFitnessDetails');
    Route::post('/changePassword','ApiController@changePassword');
    Route::get('/notificationList','ApiController@notificationList');
    Route::post('/clearNotifications','ApiController@clearNotifications');
    Route::get('/switchPushNotification','ApiController@switchPushNotification');
    Route::get('helpSupportListing', 'ApiController@helpSupportListing');
    Route::post('helpSupportFirstReply', 'ApiController@helpSupportFirstReply');
    Route::post('helpSupportReply/{query_id}', 'ApiController@helpSupportReply');
    Route::post('helpSupportDetail/{query_id}', 'ApiController@helpSupportDetail');
    Route::post('mealRating', 'ApiController@mealRating');
    Route::post('addCard', 'ApiController@addCard');
    Route::post('deleteAddCard', 'ApiController@deleteAddCard');
    Route::get('mySaveCardListing', 'ApiController@mySaveCardListing');
    Route::post('addAddress', 'ApiController@addAddress');
    Route::post('editAddress', 'ApiController@editAddress');
    Route::get('addressListing', 'ApiController@addressListing');
    Route::get('giftCardListing', 'ApiController@giftCardListing');
    Route::get('giftCardOneShow/{gift_card_id}', 'ApiController@giftCardOneShow');
    Route::post('addGiftCard', 'ApiController@addGiftCard');
    Route::get('availableCredit', 'ApiController@availableCredit');
    Route::get('creditTransactionList', 'ApiController@creditTransactionList');
    Route::post('basicInfo', 'ApiController@basicInfo');
    Route::get('promoCodeListing/{meal_plan_id}/{variant_id}', 'ApiController@promoCodeListings');
    Route::get('basicInfoDetail', 'ApiController@basicInfoDetail');
    Route::get('cities_listing', 'ApiController@cities_listing');
    Route::post('select_delivery_location', 'ApiController@select_delivery_location');
    Route::post('resume_meal_plan', 'ApiController@resume_meal_plan');
    Route::get('meal_plan_listing/{plan_types}/{plan_id}/{variant_id}', 'ApiController@meal_plan_listing');
    Route::post('sample_daily_meals', 'ApiController@sample_daily_meals'); 
    Route::post('balance_sample_daily_meals', 'ApiController@balance_sample_daily_meals'); 
    Route::any('updateBasicInfo', 'ApiController@updateBasicInfo'); 
    Route::get('delivery_slot', 'ApiController@delivery_slot');
    Route::get('social_link_listing', 'ApiController@social_link');
    Route::get('refer_and_earn', 'ApiController@refer_and_earn');
    Route::get('paymentAvailableCredit', 'ApiController@paymentAvailableCredit');
    Route::post('helpSupport', 'ApiController@helpSupport');
    Route::post('generateToken', 'ApiController@generateToken');
    Route::post('updateDietPlanHomeScreen', 'ApiController@updateDietPlanHomeScreen');
    Route::post('addAddressDeliveryNotConfirm','ApiController@addAddressDeliveryNotConfirm');
    Route::post('mantainAddressStatus', 'ApiController@mantainAddressStatus');
    Route::post('checkDaySelectedOrNot', 'ApiController@checkDaySelectedOrNot');
    Route::post('updateTimeSlotFromAddress', 'ApiController@updateTimeSlotFromAddress');
    Route::post('getPriceCalculation', 'ApiController@getPriceCalculation');
    Route::get('/otherIngredientDislikes','ApiController@otherIngredientDislikes');
    Route::get('/sendInvoice','ApiController@sendInvoice');
    // Route::post('select_start_day_meal', 'ApiController@select_start_day_meal'); 



});
