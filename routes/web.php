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

Route::get('/', 'IndexController@index')->name('index');
Route::get('/create', 'IndexController@create')->name('create');
Route::get('{id}', 'IndexController@edit')->name('edit');
Route::post('/update', 'IndexController@update')->name('update');
Route::post('/update2', 'IndexController@update2')->name('update2');
Route::post('/store', 'IndexController@store')->name('store');
Route::post('/delete', 'IndexController@delete')->name('delete');
Route::post('/find', 'IndexController@find')->name('find');

