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

	Route::post('/addVideo','ApiController@addVideo');
	Route::post('/videoDetail','ApiController@videoDetail');
        Route::post('/myVideos','ApiController@myVideos');
        Route::post('/makeFavourite','ApiController@makeFavourite');
	Route::post('/myFavourites','ApiController@myFavourites');
        Route::post('/likeVideo','ApiController@likeVideo');
        Route::post('/postLikes','ApiController@postLikes');
        Route::post('/becomeFan','ApiController@becomeFan');
        Route::get('/myFollowings','ApiController@myFollowings');
        Route::post('/userProfile','ApiController@userProfile');
        Route::get('/myFans','ApiController@myFans');
        Route::post('/blockUser','ApiController@blockUser');
        Route::post('/searchUser','ApiController@searchUser');
        Route::post('/taggedVideos','ApiController@taggedVideos');
        Route::post('/exploreVideos','ApiController@exploreVideos');
        Route::post('/updateView','ApiController@updateView');
        Route::post('/userFollowings','ApiController@userFollowings');
        Route::post('/userFans','ApiController@userFans');
        Route::post('/userVideos','ApiController@userVideos');
        Route::post('/acceptChallenge','ApiController@acceptChallenge');
        Route::post('/participants','ApiController@participants');
        Route::post('/deleteMyVideo','ApiController@deleteMyVideo');
        Route::post('/deleteParticipationVideo','ApiController@deleteParticipationVideo');
        Route::post('/addComment','ApiController@addComment');
        Route::post('/likeComment','ApiController@likeComment');
        Route::post('/commentList','ApiController@commentList');
        Route::post('/commentLikes','ApiController@commentLikes');
        Route::post('/reportPost','ApiController@reportPost');
        Route::post('/changePassword','ApiController@changePassword');
        Route::get('/notificationList','ApiController@notificationList');
        Route::get('/tagNotificationList','ApiController@tagNotificationList');
        Route::post('/clearNotifications','ApiController@clearNotifications');
        Route::post('/followingVideos','ApiController@followingVideos');
        Route::get('/reportReasons','ApiController@reportReasons');
        Route::get('/switchPushNotification','ApiController@switchPushNotification');
        Route::get('myParticipation/{start}', 'ApiController@myParticipation');
        Route::get('myParticipation', 'ApiController@myParticipation');
});
