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
 Route::get('/admin/language_selector', 'Admin\LoginController@language');



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


    /*****Gift Card Management */
    Route::get('/gift-card-management', 'Admin\GiftCardController@index');
    Route::post('/giftCard/change_status', 'Admin\GiftCardController@change_status');
    Route::post('/giftCard-delete','Admin\GiftCardController@giftCard_delete');
    Route::post('/giftCard_submit', 'Admin\GiftCardController@giftCard_submit');

    /*****End Gift Card Management */

    /****************Content Management */
    Route::get('/content-management', 'Admin\ContentController@index');
    Route::post('content/update/{id}', [
       'uses' => 'Admin\ContentController@update',
       'as' => 'admin.content.update'
   ]);
   Route::post('content/updates/{id}', [
    'uses' => 'Admin\ContentController@updates',
    'as' => 'admin.content.updates'
]);
Route::post('onboarding/updateOnboarding', 'Admin\ContentController@updateOnboarding');
Route::post('social_link/update', 'Admin\ContentController@updateSocialLink');
Route::post('homeScreen/updateBanners', 'Admin\ContentController@updateBanners');


    /*********Content Management */

    /*******Ingredient Management */
    Route::get('/ingredient-management', 'Admin\IngredientController@index');
    Route::post('/unit_submit','Admin\IngredientController@unit_submit');
    Route::post('/category/submit','Admin\IngredientController@category_submit');
    Route::post('/group/submit','Admin\IngredientController@group_submit');
    Route::post('/group/change_status','Admin\IngredientController@change_status');
    Route::post('/unit/change_status','Admin\IngredientController@unit_status');
    Route::post('/edit_group/update/{id}', [
        'uses' => 'Admin\IngredientController@update',
        'as' => 'admin.edit_group.update'
    ]);
    Route::post('/edit_category/update/{id}', [
        'uses' => 'Admin\IngredientController@update_category',
        'as' => 'admin.edit_category.update'
    ]);
    Route::get('/get_group/data/{id}', [
        'uses' => 'Admin\IngredientController@get_data',
        'as' => 'admin.get_group.data'
    ]);
    Route::get('/get_category/data/{id}', [
        'uses' => 'Admin\IngredientController@get_category_data',
        'as' => 'admin.get_category.data'
    ]);
    Route::get('/get_unit/data/{id}', [
        'uses' => 'Admin\IngredientController@get_unit_data',
        'as' => 'admin.get_unit.data'
    ]);
    Route::post('/edit_unit/update/{id}', [
        'uses' => 'Admin\IngredientController@update_unit',
        'as' => 'admin.edit_unit.update'
    ]);
    Route::post('/group-delete','Admin\IngredientController@group_delete');
    Route::post('/category-delete','Admin\IngredientController@category_delete');
    Route::post('/unit-delete','Admin\IngredientController@unit_delete');
    Route::post('/ingredient/submit','Admin\IngredientController@ingredient_submit');
    Route::post('/ingredient/change_status','Admin\IngredientController@change_status_ingredient');
    Route::post('/edit_ingredient/update/{id}', [
        'uses' => 'Admin\IngredientController@update_ingredient',
        'as' => 'admin.edit_ingredient.update_ingredient'
    ]);
    
    Route::post('/ingredient-delete','Admin\IngredientController@ingredient_delete');
    Route::post('/category/change_status','Admin\IngredientController@change_status_category');

    /*******End Ingredient Management */

    /*******Fitness Goal Management */
    Route::get('/fitnessGoal-management', 'Admin\FitnessGoalController@index');
    Route::post('/fitness_goal/change_status','Admin\FitnessGoalController@change_status');
    Route::post('/fitness-goal/submit','Admin\FitnessGoalController@submit');

    /*******End Fitness Goal Management */

    /*******Diet Plan Management */
    Route::get('/dietPlan-management', 'Admin\DietPlanController@index');
    Route::post('/diet_plan/change_status','Admin\DietPlanController@change_status');
    Route::get('/add-diet-plan','Admin\DietPlanController@add_diet_plan');
    Route::post('/diet-plan/submit','Admin\DietPlanController@submit');
    Route::any('edit-dietPlan/{id}', 'Admin\DietPlanController@edit_dietPlan');
    Route::post('/dietPlan/edit_update/{id}','Admin\DietPlanController@edit_update');

    /*******End Diet Plan Management */


/*******User  Management */
    Route::get('/user-management', 'Admin\UserController@index');
    Route::get('/user-details/{id}', 'Admin\UserController@show');
    Route::post('/user-post-filter', ['uses' => 'Admin\UserController@user_post_filter', 'as' => 'admin.user_post.filter']);
    Route::post('/user/change_user_status', 'Admin\UserController@change_user_status');
    Route::post('/user/filter', [
        'uses' => 'Admin\UserController@filter_list',
        'as' => 'admin.user.filter'
    ]);
    Route::post('/query/filter', [
        'uses' => 'Admin\UserController@filter_list',
        'as' => 'admin.query.filter'
      ]);
     /*******End User Management */


     /*****Staff Management */
    Route::get('/staff-management', 'Admin\StaffController@index');
    Route::get('/add_staff_group','Admin\StaffController@add_staff_group');
    Route::post('/staff_group_status/change_status','Admin\StaffController@change_status');
    Route::post('/staff-group-delete','Admin\StaffController@group_delete');
    Route::post('/staff_group/submit','Admin\StaffController@submit');
    Route::post('/edit_staff_group/update/{id}', [
        'uses' => 'Admin\StaffController@update',
        'as' => 'admin.edit_staff_group.update'
    ]);
    Route::get('/get_staff_group/data/{id}', [
        'uses' => 'Admin\StaffController@get_staff_data',
        'as' => 'admin.get_staff_group.data'
    ]);
    Route::get('/get_staff_member/data/{id}', [
        'uses' => 'Admin\StaffController@get_staff_member_data',
        'as' => 'admin.get_staff_member.data'
    ]);
    Route::post('/staff_member/submit','Admin\StaffController@staff_member_submit');
    Route::post('/staff_member/change_status','Admin\StaffController@staff_member_change_status');
    Route::post('/edit_staff_member/update/{id}', [
        'uses' => 'Admin\StaffController@update_member',
        'as' => 'admin.edit_staff_member.update'
    ]);
     /*****End Staff Management */


     /*******Promo Code  Management */
    Route::get('/promo-code-management', 'Admin\PromoController@index');
    Route::post('/promoCode_submit', 'Admin\PromoController@promoCode_submit');
    Route::post('/promoCode/change_status', 'Admin\PromoController@change_status');
    Route::post('/promoCode-delete','Admin\PromoController@promoCode_delete');
    Route::post('/user/filter', [
        'uses' => 'Admin\PromoController@filter_list',
        'as' => 'admin.user.filter'
    ]);
     /*******End Promo Code Management */

     
     /*******Refer and earn Management */
    Route::get('/refer-earn-management', 'Admin\ReferAndEarnController@index');
    Route::post('/refer_earn_submit', 'Admin\ReferAndEarnController@refer_earn_submit');
    Route::post('/refercontent/update', 'Admin\ReferAndEarnController@refer_content_update');
    Route::post('/refer_earn/update_content/{id}', 'Admin\ReferAndEarnController@update_content');
     /*******End refer and earn Management */

         /*******Meal Management */
    Route::get('/meal-management', 'Admin\MealController@index');
    Route::get('/add-meal', 'Admin\MealController@add_meal');
    Route::post('/meal/submit', 'Admin\MealController@meal_submit');
    Route::post('/meal/change_status', 'Admin\MealController@change_status');
     /*******End Meal Management */

        /*******Meal Plan Management */
    Route::get('/meal-plan-management', 'Admin\MealPlanController@index');
    Route::get('/add-mealplan', 'Admin\MealPlanController@add_meal');
    Route::post('/add_variants', 'Admin\MealPlanController@add_variants');
    Route::post('/mealplan/submit', 'Admin\MealPlanController@meal_plan_submit');
    Route::post('/mealplan/change_status', 'Admin\MealPlanController@change_status');
    Route::any('edit-mealplan/{id}', 'Admin\MealPlanController@editMealPlan');
    Route::post('/edit-mealplan/edit_update/{id}','Admin\MealPlanController@edit_update');

     /*******End Meal Plan Management */

 /*******upcoming deliveries Management */
     Route::get('/upcoming-deliveries', 'Admin\AdminController@upcoming_deliveries');
     Route::any('/upcomingDeliveriesShow', 'Admin\AdminController@upcomingDeliveriesShow');


 /*******upcoming deliveries Management */

 /*******order Management */
 Route::get('/order-management', 'Admin\OrderController@index');
 Route::post('/currentPlan/change_currentPlan_status', 'Admin\OrderController@change_status');
 Route::post('/currentPlan/change_previousPlan_status', 'Admin\OrderController@change_previousPlan_status');
 Route::get('/order-details/{id}', 'Admin\OrderController@show');
 Route::get('/previous-order-details/{id}/{plan_id}', 'Admin\OrderController@previousPlanShow');
 Route::post('/updateDeliveryStatus', 'Admin\OrderController@updateDeliveryStatus');
 /*******End order Management */

 /*******fleet Management */
    Route::get('/fleet-management', 'Admin\FleetController@index');
    Route::post('/fleetarea/submit', 'Admin\FleetController@addArea');
    Route::post('/fleetarea/change_status', 'Admin\FleetController@change_status');
    Route::post('fleetarea/edit', 'Admin\FleetController@editArea')->name('area.edit');
    Route::post('/fleetarea/edit_update/{id}','Admin\FleetController@edit_update');
    Route::post('/fleetdriver/submit', 'Admin\FleetController@storeFleetDriver');
 /*******End fleet Management */

 /*******Notification Management */
 Route::get('/notification-management', 'Admin\NotificationController@index');
    Route::post('/brodcastnotify/submit', 'Admin\NotificationController@storeBroadCastNotification');
    Route::post('/popupnotify/submit', 'Admin\NotificationController@storePopupNotification');

/*******End Notification Management */


/*******Report Management */

Route::get('/report-management', 'Admin\ReportController@index');
Route::post('/search_packing_list', 'Admin\ReportController@search_packing_list');
/*******End Report Management */



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



/******Driver Route*******/
Route::get('/driver', 'Driver\LoginController@index')->name('driver.index');
Route::get('/driver/login', 'Driver\LoginController@login')->name('driver.login');
Route::post('/driver/login', 'Driver\LoginController@postLogin')->name('driver.login');
Route::get('/driver/sendotp', 'Driver\LoginController@sendotp')->name('driver.sendotp');
Route::get('/driver/resetpassword', 'Driver\LoginController@resetpassword')->name('driver.resetpassword');
Route::get('/driver/forgotpassword', 'Driver\LoginController@forgotpassword')->name('driver.forgotpassword');


Route::group(['middleware' => ['\App\Http\Middleware\DriverAuth'], 'prefix' => 'driver'], function () {

    Route::get('dashboard', 'Driver\DashboardController@index')->name('dashboard');
    Route::get('profile', 'Driver\DashboardController@profileIndex')->name('profile');
    Route::get('logout', 'Driver\LoginController@getLogout')->name('logout');

    Route::get('orderdetails/{id}', 'Driver\OrderController@orderDetails')->name('orderdetails');
    Route::get('navigation/{id}', 'Driver\OrderController@navigation')->name('navigation');
    Route::get('cancelorder/{id}', 'Driver\OrderController@orderCancel')->name('cancelorder');
    Route::post('submitcancelorder', 'Driver\OrderController@submitCancelOrder')->name('submitcancelorder');
    Route::get('/scanorder', 'Driver\LoginController@scanorders')->name('scanorders');
    Route::get('/scanorderfail', 'Driver\LoginController@scanFail')->name('scanorderfail');
    Route::get('/scanordersuccess', 'Driver\LoginController@scanSuccess')->name('scanordersuccess');

    Route::post('/storeLocation', 'Driver\LoginController@storeLocation');
});
/***********end driver route************/

Route::any('payfort',function(Request $request){
    return view('payfort.index');
});