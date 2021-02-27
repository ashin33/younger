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
    return redirect()->route('order_date.index');
});

Route::group([
    'namespace' => 'OrderDate',
    'prefix' => 'order_date'
], function () {
    Route::get('/', 'OrderDateController@index')->name('order_date.index');
});

Route::group([
    'namespace' => 'V1Order',
    'prefix' => 'orders'
], function () {
    Route::get('/{date}', 'OrderController@index')->name('order.index');
    Route::get('/{date}/download', 'OrderController@download')->name('order.download');
    Route::get('/{id}/download', 'OrderController@download')->name('order.download');
    Route::get('/{id}/print', 'OrderController@print')->name('order.print');
});

Route::group([
    'namespace' => 'Application',
    'prefix' => 'applications'
], function () {
    Route::get('/', 'ApplicationController@index')->name('application.index');
    Route::get('/create', 'ApplicationController@create')->name('application.create');
    Route::post('/store', 'ApplicationController@store')->name('application.store');
});

Route::group([
    'namespace' => 'Printer',
    'prefix' => 'printers'
], function () {
    Route::get('/', 'PrinterController@index')->name('printer.index');
    Route::get('/create', 'PrinterController@create')->name('printer.create');
    Route::post('/store', 'PrinterController@store')->name('printer.store');
    Route::post('/{id}/authorize', 'PrinterController@authorize')->name('printer.authorize');
});
