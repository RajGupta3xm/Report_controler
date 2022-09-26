<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

/* For run migrate on server */
Route::get('/dump', function () {
    system('composer dump-autoload');
});
Route::get('/refreshSeed', function () {
    echo Artisan::call('migrate:refresh --seed');
});
Route::get('/migrate', function () {
    echo Artisan::call('migrate');
});
Route::get('/seed', function () {
    echo Artisan::call('db:seed');
});
Route::get('/optimize', function () {
    echo Artisan::call('optimize');
});
Route::get('/composer-update', function () {
    echo Artisan::call('composer update');
});
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
});
Route::get('/clear-config', function() {
    Artisan::call('config:clear');
});
Route::get('/m-i-g-r-a-t-e-rollback', function() {
    Artisan::call('migrate:rollback');
});
/* For run migrate on server */


// Route::get('/', function () {
// 	// dd('a');
// 	return redirect('admin/login');
// });

/* * *********Localization*********** */

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/admin', 'Admin\LoginController@login')->name('login');
Route::get('/admin/login', 'Admin\LoginController@login')->name('login');
Route::post('/admin/dologin', 'Admin\LoginController@authenticate');
Route::get('/admin/logout', 'Admin\AdminController@getLogout');
Route::get('/admin/error', 'Admin\LoginController@error')->name('error');
Route::get('/admin/forgot', 'Admin\LoginController@forgot');
Route::post('/admin/forgotten', 'Admin\LoginController@forgotten');
Route::any('otp/{id}', [
    'as' => 'otp',
    'uses' => 'Admin\LoginController@showotp'
 ]);
 Route::post('/admin/checkOTP', 'Admin\LoginController@checkOTP');
 Route::get('/admin/resetPassword/{id}', 'Admin\LoginController@resetPassword')->name('resetPassword');
 Route::post('/admin/ConfirmPassword', 'Admin\LoginController@ConfirmPassword');
 Route::post('/admin/resend_otp','Admin\LoginController@resendotp');



Route::group(['middleware' => ['\App\Http\Middleware\AdminAuth'], 'prefix' => 'admin'], function () {
    Route::get('/home', 'Admin\AdminController@dashboard')->middleware('admin')->name('home');
    Route::get('/dashboard', 'Admin\AdminController@dashboard')->name('dashboard');
    Route::get('change_password','Admin\AdminController@change_password');
    Route::post('/edit_passwordUpdate','Admin\AdminController@password_update');
    Route::get('/edit_profile','Admin\AdminController@edit_profile');
    Route::post('/edit_profileUpdate/{id}','Admin\AdminController@edit_update');


    /*******Help And Support */

    Route::get('/support-management','Admin\SupportController@index');
    Route::post('/query/change_status','Admin\SupportController@change_status');
    Route::post('/query-delete','Admin\SupportController@query_delete');
    Route::post('/query/filter', [
        'uses' => 'Admin\SupportController@filter_list',
        'as' => 'admin.query.filter'
      ]);
      Route::any('query/chat', 'Admin\SupportController@queryChat');
      Route::post('query/reply', 'Admin\SupportController@query_reply');

    /******End Help And Support */


    Route::get('/user-management', 'Admin\UserController@index');
    Route::get('/user-detail/{id}', 'Admin\UserController@show');
    Route::post('/user-post-filter', ['uses' => 'Admin\UserController@user_post_filter', 'as' => 'admin.user_post.filter']);
    Route::post('/user/change_user_status', 'Admin\UserController@change_user_status');
    Route::post('/user/filter', [
        'uses' => 'Admin\UserController@filter_list',
        'as' => 'admin.user.filter'
    ]);
    Route::get('/category-management', 'Admin\CategoryController@index');
    Route::post('category/store', [
        'uses' => 'Admin\CategoryController@store',
        'as' => 'admin.category.store'
    ]);
    Route::get('edit-category/{id}', 'Admin\CategoryController@edit');
    Route::post('category/update/{id}', [
        'uses' => 'Admin\CategoryController@update',
        'as' => 'admin.category.update'
    ]);
    Route::post('/category/change_category_status', 'Admin\CategoryController@change_category_status');
    Route::post('/category/delete', 'Admin\CategoryController@delete_category');

    Route::get('/video-management', 'Admin\UserController@videoList');
    Route::get('/video-detail/{id}', 'Admin\UserController@videoDetail');
    Route::post('/video/change_video_status', 'Admin\UserController@change_video_status');
    Route::post('/video/filter', [
        'uses' => 'Admin\UserController@filter_video_list',
        'as' => 'admin.video.filter'
    ]);
    Route::get('/participants/{id}', 'Admin\UserController@participants');
    Route::post('/video/change_participationvideo_status', 'Admin\UserController@change_participationvideo_status');
    Route::get('/report-management', 'Admin\UserController@reportList');
    Route::get('/report-detail/{id}', 'Admin\UserController@reportDetail');
    Route::post('/report/filter', [
        'uses' => 'Admin\UserController@filter_report_list',
        'as' => 'admin.report.filter'
    ]);
   
    
    Route::get('/reason-management', 'Admin\AdminController@reason_list');
    Route::post('reason/store', [
        'uses' => 'Admin\AdminController@reason_store',
        'as' => 'admin.reason.store'
    ]);
    Route::get('edit-reason/{id}', 'Admin\AdminController@edit_reason');
    Route::post('reason/update/{id}', [
        'uses' => 'Admin\AdminController@reason_update',
        'as' => 'admin.reason.update'
    ]);
    Route::post('/reason/change_category_status', 'Admin\AdminController@change_reason_status');
    Route::post('/reason/delete', 'Admin\AdminController@delete_reason');
    Route::any('/custom-notification', 'Admin\AdminController@customNotification');
    Route::get('/notification-management', 'Admin\AdminController@notificationList');
    Route::get('/notification-detail/{id}', 'Admin\AdminController@notificationDetails');

});
Route::get('/', 'Website\WebController@index');
Route::group(['namespace' => 'Website'], function () {
    
    Route::get('/home', 'WebController@index')->name('home');
    Route::get('/about', 'WebController@about')->name('about');
    Route::get('/terms-condition', 'WebController@terms_condition')->name('terms');
    Route::get('/privacy-policy', 'WebController@privacy_policy')->name('policy');

    Route::get('/interior', 'WebController@interior')->name('interior');
    Route::get('/exterior', 'WebController@exterior')->name('exterior');
    Route::get('/performance', 'WebController@performance')->name('performance');
    Route::get('/lighting', 'WebController@lighting')->name('lighting');
    Route::get('/wheels', 'WebController@wheels')->name('wheels');
    Route::get('/parts', 'WebController@parts')->name('parts');

    Route::get('/product', 'WebController@product')->name('product');
    Route::get('/product-single', 'WebController@product_single')->name('product-single');
    Route::get('/add-new-address', 'WebController@add_new_address')->name('add_new_address');
    Route::get('/payment', 'WebController@payment')->name('payment');
    Route::get('/add-new-card', 'WebController@add_new_card')->name('add-new-card');
    Route::get('/mycart', 'WebController@mycart')->name('mycart');
    Route::get('/checkout', 'WebController@checkout')->name('checkout');
    Route::get('/myaccount', 'WebController@myaccount')->name('myaccount');
    Route::post('/setsessiondetails', 'WebController@set_session_details');
});

// Route::get('/', function () {
//     return view('welcome');
// });