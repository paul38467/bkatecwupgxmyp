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
    Route::get('layouts', function () {
        return view('test_views.layouts');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
