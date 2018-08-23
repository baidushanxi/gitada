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
Route::get('/', 'DataNewController@index')->name('ada.index');

Route::get('/ada/data', 'DataController@index')->name('ada.data');
Route::get('/ada/data/export', 'DataController@export')->name('ada.data.export');

Route::get('/ada/datanew', 'DataNewController@index')->name('ada.datanew');
Route::get('/ada/datanew/detail', 'DataNewController@detail')->name('adaDataNew.detail');


Route::get('/ada/data/loadStatus', 'DataController@loadStatus')->name('ada.data.loadStatus');
Route::get('/ada/data/unitPrice', 'UnitPriceController@index')->name('ada.data.unitPrice');


Route::get('/ada/shop', 'ShopController@index')->name('ada.shop');
Route::get('/ada/shop/{id}', 'ShopController@edit')->name('ada.shop.edit');
Route::post('/ada/shop/{id}', 'ShopController@update');


Route::get('/ada/spread/index', 'SpreadController@index')->name('ada.spread');
Route::get('/ada/spread/create', 'SpreadController@create')->name('ada.spread.create');
Route::post('/ada/spread/create', 'SpreadController@store');


Route::get('/ada/deliver/index', 'DeliverController@index')->name('ada.deliver');
Route::get('/ada/deliver/create', 'DeliverController@create')->name('ada.deliver.create');
Route::post('/ada/deliver/create', 'DeliverController@store');



