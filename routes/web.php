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

Route::prefix('test-views')->group(function () {
    Route::view('layouts', 'test_views.layouts');
    Route::view('bdcallout', 'test_views.bdcallout');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
