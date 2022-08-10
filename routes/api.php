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

Route::get('/countryList','Auth\ApiController@countryList');
Route::get('/getLogout', 'Auth\ApiController@getLogout');
Route::get('/authfail', 'Controller@authfail');
Route::post('/helpSupport','Auth\ApiController@helpSupport');
Route::get('/aboutUs','Auth\ApiController@aboutUs');
Route::get('/privacyPolicy','Auth\ApiController@privacyPolicy');
Route::get('/termsConditions','Auth\ApiController@termsConditions');

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
});
