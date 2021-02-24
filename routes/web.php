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
    return redirect()->route('order.index');
});



Route::group([
    'namespace' => 'Order',
    'prefix' => 'orders'
], function () {
    Route::get('/', 'OrderController@index')->name('order.index');
    Route::get('/{date}/detail', 'OrderController@detail')->name('order.detail');
    Route::get('/{date}/download', 'OrderController@download')->name('order.download');
});

Route::group([
    'namespace' => 'Printer',
    'prefix' => 'printer'
], function () {
    Route::get('/manage', 'PrinterController@manage')->name('printer.manage');
    Route::get('/list', 'PrinterController@list')->name('printer.list');
});
