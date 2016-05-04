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
    Route::get('category/{cid}/attributes', 'Product\AttributeController@showAttributes');
    Route::get('attribute/{aid}', 'Product\AttributeController@showAttribute');
    Route::get('product/load', 'Product\ProductController@loadProduct');
    Route::get('product/{pid}/sku', 'Product\ProductController@loadSku');
    Route::get('sku/{sku}', 'Product\ProductController@getSku');
    Route::post('upload', 'UploadController@store');
    Route::resource('home', 'HomeController', ['only' => ['index']]);
    Route::resource('user.password', 'User\PasswordController');
    Route::resource('supplier', 'Product\SupplierController');
    Route::resource('category', 'Product\CategoryController');
    Route::resource('category.attribute', 'Product\AttributeController');
    Route::resource('attribute.value', 'Product\AttributeValueController');
    Route::resource('product', 'Product\ProductController');
    Route::resource('order', 'Order\OrderController');
});

