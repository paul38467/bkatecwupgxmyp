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

Route::view('/test-views/test-layouts', 'test_views.test_layouts');
Route::view('/test-views/test-bdcallout', 'test_views.test_bdcallout');
Route::view('/test-views/test-alert', 'test_views.test_alert');
Route::view('/test-views/test-alert-with', 'test_views.test_alert_with');

Route::resource('region', 'RegionController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
