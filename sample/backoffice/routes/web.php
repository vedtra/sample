<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['role:admin','permission:acces configuration']], function () {
	Route::get('/', 'Configuration\PermissionController@index')->name('permissionindex');
	Route::get('/loadjson', 'Configuration\PermissionController@get')->name('permissionloadjson');
	Route::get('/create', 'Configuration\PermissionController@create')->name('createpermission');
    Route::get('/edit/{id}', 'Configuration\PermissionController@edit')->name('editpermission');
	Route::post('/save', 'Configuration\PermissionController@store')->name('savepermission');
	Route::get('/delete/{id}', 'Configuration\PermissionController@destroy')->name('deletepermission');
	/*====MANAGER===*/
	Route::get('/manager', 'Configuration\PermissionManagerController@index')->name('permissionmanager');
	Route::post('/manager', 'Configuration\PermissionManagerController@store')->name('savepermissionmanager');

});

/*=================Roles=================*/
Route::group(['middleware' => 'auth','prefix' => 'role'], function () {
	Route::get('/', 'Configuration\RoleController@index')->name('roleindex');
	Route::get('/loadjson', 'Configuration\RoleController@get')->name('roleloadjson');
	Route::get('/create', 'Configuration\RoleController@create')->name('createrole');
    Route::get('/edit/{id}', 'Configuration\RoleController@edit')->name('editrole');
	Route::post('/save', 'Configuration\RoleController@store')->name('saverole');
	Route::get('/delete/{id}', 'Configuration\RoleController@destroy')->name('deleterole');
});

/*=================user=================*/
Route::group(['middleware' => 'auth','prefix' => 'account'], function () {
	Route::get('/', 'Configuration\AccountController@index')->name('accountindex');
	Route::get('/loadjson', 'Configuration\AccountController@get')->name('accountloadjson');
	Route::get('/create', 'Configuration\AccountController@create')->name('createaccount');
    Route::get('/edit/{id}', 'Configuration\AccountController@edit')->name('editaccount');
	Route::post('/save', 'Configuration\AccountController@store')->name('saveaccount');
	Route::get('/delete/{id}', 'Configuration\AccountController@destroy')->name('deleteaccount');
});

/*=================Permission=================*/
Route::group(['middleware' => 'auth','prefix' => 'permission'], function () {


});

/*=================Profile=================*/
Route::group(['middleware' => 'auth','prefix' => 'profile'], function () {
	Route::get('/password', 'Profile\ProfileController@formPassword')->name('formpasswd');
	Route::post('/password', 'Profile\ProfileController@updatePassword')->name('updatepasswd');
});

/*=================Company Category=================*/
Route::group(['middleware' => 'auth','prefix' => 'categorycompany'], function () {
	Route::get('/', 'Company\CompanyCategoryController@index')->name('categorycompanyindex');
	Route::get('/loadjson', 'Company\CompanyCategoryController@get')->name('categorycompanyloadjson');
	Route::get('/create', 'Company\CompanyCategoryController@create')->name('createcompanycategory');
	Route::get('/edit/{id}', 'Company\CompanyCategoryController@edit')->name('editcategorycompany');
	Route::post('/save', 'Company\CompanyCategoryController@store')->name('savecategorycompany');
    Route::get('/delete/{id}', 'Company\CompanyCategoryController@destroy')->name('deletecategorycompany');
});
/*=================Company=================*/
Route::group(['middleware' => 'auth','prefix' => 'company'], function () {
	Route::get('/', 'Company\CompanyController@index')->name('companyindex');
	Route::get('/loadjson', 'Company\CompanyController@get')->name('companyloadjson');
	Route::get('/create', 'Company\CompanyController@create')->name('createcompany');
	Route::get('/edit/{id}', 'Company\CompanyController@edit')->name('editcompany');
	Route::post('/save', 'Company\CompanyController@store')->name('savecompany');
    Route::get('/delete/{id}', 'Company\CompanyController@destroy')->name('deletecompany');

});

/*=================Setup Company=================*/
Route::group(['middleware' => 'auth','prefix' => 'setupcompany'], function () {

	Route::get('/edit', 'Company\SetupCompanyController@edit')->name('setupeditcompany');
	Route::post('/save', 'Company\SetupCompanyController@store')->name('savesetupcompany');


});

/*=================Setup operational=================*/
Route::group(['middleware' => 'auth','prefix' => 'setupoperational'], function () {
	Route::get('/edit', 'Company\SetupOperationalController@edit')->name('setupeditoperational');
	Route::post('/save', 'Company\SetupOperationalController@store')->name('savesetupoperational');

});


/*=================Account Company=================*/
Route::group(['middleware' => 'auth','prefix' => 'accountcompany'], function () {
    Route::get('/', 'Company\AccountCompanyController@index')->name('accountcompanyindex');
	Route::get('/loadjson', 'Company\AccountCompanyController@get')->name('accountcompanyloadjson');
	Route::get('/create', 'Company\AccountCompanyController@create')->name('createcompanyaccount');
    Route::get('/edit/{id}', 'Company\AccountCompanyController@edit')->name('editcompanyaccount');
	Route::post('/save', 'Company\AccountCompanyController@store')->name('savecompanyaccount');
	Route::get('/delete/{id}', 'Company\AccountCompanyController@destroy')->name('deletecompanyaccount');
});


/*=================Transport=================*/
Route::group(['middleware' => 'auth','prefix' => 'transport'], function () {
	Route::get('/', 'Transport\TransportController@index')->name('transportindex');
	Route::get('/loadjson', 'Transport\TransportController@get')->name('transportloadjson');
	Route::get('/create', 'Transport\TransportController@create')->name('createttransport');
	Route::get('/edit/{id}', 'Transport\TransportController@edit')->name('edittransport');
	Route::post('/save', 'Transport\TransportController@store')->name('savetransport');
    Route::get('/delete/{id}', 'Transport\TransportController@destroy')->name('deletetransport');

    /*Sub Group dari Transport*/
    /*=================Transport Category=================*/
	Route::group(['middleware' => 'auth','prefix' => 'category'], function () {
		Route::get('/', 'Transport\TransportCategoryController@index')->name('categorytransportindex');
		Route::get('/loadjson', 'Transport\TransportCategoryController@get')->name('categoryloadjson');
		Route::get('/create', 'Transport\TransportCategoryController@create')->name('createcategorytransport');
		Route::get('/edit/{id}', 'Transport\TransportCategoryController@edit')->name('editcategorytransport');
		Route::post('/save', 'Transport\TransportCategoryController@store')->name('savecategorytransport');
	    Route::get('/delete/{id}', 'Transport\TransportCategoryController@destroy')->name('deletecategorytransport');
	});

	/*=================Transport Type=================*/
	Route::group(['middleware' => 'auth','prefix' => 'type'], function () {
		Route::get('/', 'Transport\TransportTypeController@index')->name('typetransportindex');
		Route::get('/loadjson', 'Transport\TransportTypeController@get')->name('typetransportloadjson');
		Route::get('/create', 'Transport\TransportTypeController@create')->name('createtypetransport');
		Route::get('/edit/{id}', 'Transport\TransportTypeController@edit')->name('edittypetransport');
		Route::post('/save', 'Transport\TransportTypeController@store')->name('savetypetransport');
	    Route::get('/delete/{id}', 'Transport\TransportTypeController@destroy')->name('deletetypetransport');
	});

});

/*=================Blog=================*/
Route::group(['middleware' => 'auth','prefix' => 'blog'], function () {
	Route::get('/', 'Blog\BlogController@index')->name('blogindex');
	Route::get('/loadjson', 'Blog\BlogController@get')->name('blogloadjson');
	Route::get('/create', 'Blog\BlogController@create')->name('createblog');
	Route::get('/edit/{id}', 'Blog\BlogController@edit')->name('editblog');
	Route::post('/save', 'Blog\BlogController@store')->name('saveblog');
    Route::get('/delete/{id}', 'Blog\BlogController@destroy')->name('deleteblog');
});
/*=================Coupon=================*/
Route::group(['middleware' => 'auth','prefix' => 'coupon'], function () {
	Route::get('/', 'Coupon\CouponController@index')->name('couponindex');
	Route::get('/loadjson', 'Coupon\CouponController@get')->name('couponloadjson');
	Route::get('/create', 'Coupon\CouponController@create')->name('createcoupon');
	Route::get('/edit/{id}', 'Coupon\CouponController@edit')->name('editcoupon');
	Route::post('/save', 'Coupon\CouponController@store')->name('savecoupon');
    Route::get('/delete/{id}', 'Coupon\CouponController@destroy')->name('deletecoupon');
});
