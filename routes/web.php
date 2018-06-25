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

Route::view('/test-views/layouts', 'test_views.layouts');
Route::view('/test-views/bdcallout', 'test_views.bdcallout');
Route::view('/test-views/alert-with', 'test_views.alert_with');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
