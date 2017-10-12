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

//sites routes

Route::namespace('Site')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
});

Route::get('addToCart/{id}', 'Admin\ProductsController@addToCart')->name('addToCart');


Route::get('/admin-page', 'AdminController@index')->name('admin.dashboard');

Auth::routes();
Route::get('/users/confirmation/{token}', 'Auth\RegisterController@confirmation')->name('confirmation');

Route::get('/profile', 'HomeController@index')->name('profile');
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');


Route::group(['prefix'=>'admin'], function(){
    Route::get('/login', 'Admin\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Admin\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Admin\AdminLoginController@logout')->name('admin.logout');

    //Password reset routs
    Route::post('/password/email', 'Admin\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('/password/reset', 'Admin\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset', 'Admin\AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'Admin\AdminResetPasswordController@showResetForm')->name('admin.password.reset');

        // admin resource routs
Route::group(['middleware'=>['auth:admin'], ['SetLocale']], function(){
    Route::resource('customers', 'Admin\CustomersController');
    Route::resource('brands', 'Admin\BrandsController');
    Route::resource('product-categories', 'Admin\ProductCategoriesController');


    // products image routes

    Route::post('products/image-upload/{id}', 'Admin\ProductsController@newImagesUpload')->name('new-images-upload');
    Route::post('products/imageReload', 'Admin\ProductsController@imageReload');
    Route::post('products/addNewImage', 'Admin\ProductsController@addNewImage');
    Route::post('products/deleteImage/{id}', 'Admin\ProductsController@deleteImage');
    Route::resource('products', 'Admin\ProductsController');


    //category image routes

    Route::post('categories/imageReload', 'Admin\ProductCategoriesController@imageReload');

    //brands image routes
    Route::post('brands/imageReload', 'Admin\BrandsController@imageReload');



    Route::resource('users', 'Admin\UsersController');
    Route::get('/brandsRip', 'Admin\BrandsController@brandRip')->name('brands.rip');

    // language-selector route
    Route::post('changelocale', 'LanguageController@changelocale')->name('changelocale');
});
    Route::get('orders', [
        'uses' => 'Admin\OrdersController@index',
        'as' => 'orders.index',
    ]);
});


