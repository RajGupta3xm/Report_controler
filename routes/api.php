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
Route::get('/termsConditions','Auth\ApiController@termsConditions');
Route::get('/onboardingScreen','Auth\ApiController@onboardingScreen');

// Route::post('insertImage', 'Auth\ApiController@insertImage');

Route::group(['middleware' => 'auth:api','namespace' => 'Auth'], function(){	
	Route::get('myProfile', 'ApiController@myProfile');
	Route::post('/editProfile','ApiController@editProfile');
    Route::get('/homescreen','ApiController@homescreen');
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
    Route::post('addGiftCard', 'ApiController@addGiftCard');
    Route::get('availableCredit', 'ApiController@availableCredit');
    Route::get('creditTransactionList', 'ApiController@creditTransactionList');
    Route::post('basicInfo', 'ApiController@basicInfo');
    Route::get('promoCodeListing', 'ApiController@promoCodeListings');
    







});
