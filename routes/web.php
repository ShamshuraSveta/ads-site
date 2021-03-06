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

Route::get('/', 'AdController@index');

Route::resource('/ads','AdController');

Auth::routes();

Route::resource('/user','UserController');

Route::resource('/comments','CommentController');