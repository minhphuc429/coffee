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

Route::prefix('dashboard')->group(function () {
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

    Route::get('file','FileController@index');
    Route::post('file','Filecontroller@doUpload');
});