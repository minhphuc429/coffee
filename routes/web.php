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

Route::get('/redirect/{social}', 'SocialAuthController@redirectToProvider');
Route::get('/callback/{social}', 'SocialAuthController@handleProviderCallback');

Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('dashboard')->group(function () {
    Route::middleware('role:manager')->group(function () {
        Route::resource('categories', 'CategoryController')->except([
            'show'
        ]);

        Route::resource('products', 'ProductController')->except([
            'show'
        ]);

        Route::resource('users', 'UserController')->except([
            'show'
        ]);

        Route::resource('roles', 'RoleController')->except([
            'show'
        ]);

        Route::resource('orders', 'OrderController');
    });
});


Route::get('cart', 'CartController@index');
Route::post('get-product-options', 'ProductController@getProductOption');

Route::prefix('order')->group(function () {
    Route::get('/', 'OrderController@create');
    Route::post('InsertShoppingCartItem', 'CartController@InsertShoppingCartItem');
    Route::post('UpdateShoppingCartItem', 'CartController@UpdateShoppingCartItem');
    Route::post('RemoveShoppingCartItem', 'CartController@RemoveShoppingCartItem');
    Route::get('completion', 'CartController@completion');
    Route::post('completion', 'OrderController@store');

    Route::middleware('auth')->group(function () {
        Route::get('history', 'OrderController@orderHistory');
        Route::get('detail/{id}', 'OrderController@orderDetail')
            ->where('id', '[0-9]+')
            ->name('order.detail');
        Route::post('cancel', 'OrderController@cancelOrder')
            ->name('order.cancel');
    });
});

Route::prefix('tai-khoan')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', 'UserController@editInformation');
        Route::post('/', 'UserController@updateInformation');
        Route::get('doi-mat-khau', function () {
            return view('auth.passwords.update');
        });
        Route::post('doi-mat-khau', 'UserController@updatePassword');
    });
});
