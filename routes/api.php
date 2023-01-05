<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix'=>'auth'],function (){
    Route::post('register','AuthController@register');
    Route::post('login','AuthController@login');
});


Route::group(['prefix'=>'products'],function (){
    Route::get('/','ProductController@products');
});


Route::group(['prefix'=>'carts','middleware'=>'jwtAuth'],function (){
    Route::get('/','CartController@index');
    Route::post('/store','CartController@store');
    Route::post('/update/{id}','CartController@update');
    Route::post('/delete/{id}','CartController@delete');
});


Route::group(['prefix'=>'order'],function (){
    Route::post('/','OrderController@checkout');
});
