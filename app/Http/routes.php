<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/dash', function() {
    return redirect('home');
});

Route::get('/', function () {
    return redirect('home');
});

// 登录注册
Route::controllers(['auth' => 'Auth\AuthController', 'password' => 'Auth\PasswordController']);

Route::group(['middleware' => 'auth'], function() {
    Route::resource('home', 'HomeController', ['only' => ['index']]);
    Route::resource('supplier', 'Product\SupplierController');
    Route::resource('category', 'Product\CategoryController');
    Route::resource('category.attribute', 'Product\AttributeController');
    Route::resource('attribute.value', 'Product\AttributeValueController');
});

