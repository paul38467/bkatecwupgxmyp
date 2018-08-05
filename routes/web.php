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

Route::prefix('fetchaa')->name('fetchaa.')->group(function () {
    Route::get('/', 'FetchaaController@index')->name('index');
    Route::get('empty/{field}', 'FetchaaController@empty')->where('field', '(av_icode|artist|both)')->name('empty');
    Route::get('dupe-av-icode', 'FetchaaController@dupeAvIcode')->name('dupe-av-icode');
    Route::get('is-focus', 'FetchaaController@isFocus')->name('is-focus');
    Route::get('edit/{thread}', 'FetchaaController@edit')->name('edit');
    Route::get('unread', 'FetchaaController@unread')->name('unread');
    Route::get('import', 'FetchaaController@import')->name('import');
    Route::post('store-import', 'FetchaaController@storeImport')->name('store-import');
    Route::post('markread', 'FetchaaController@markread')->name('markread');
    Route::post('merge/{thread}', 'FetchaaController@merge')->name('merge');
    Route::patch('update/{thread}', 'FetchaaController@update')->name('update');
    Route::delete('destroy/{thread}', 'FetchaaController@destroy')->name('destroy');
});

Route::prefix('region')->name('region.')->group(function () {
    Route::get('/', 'RegionController@index')->name('index');
    Route::get('edit/{region}', 'RegionController@edit')->name('edit');
    Route::post('store', 'RegionController@store')->name('store');
    Route::patch('update/{region}', 'RegionController@update')->name('update');
    Route::delete('destroy/{region}', 'RegionController@destroy')->name('destroy');
});

Route::resource('artist-tagcat', 'ArtistTagcatController');
Route::resource('artist-tag', 'ArtistTagController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
