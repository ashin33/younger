<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

], function () {
    Route::post('order_entry', 'YoungerController@orderEntry')->name('younger.order_entry');
    Route::get('order_list', 'YoungerController@order')->name('younger.order');
    Route::get('order_date_list', 'YoungerController@date')->name('younger.date');
});
