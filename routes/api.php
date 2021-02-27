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
    'namespace' => 'V1',
], function () {
    Route::post('order_entry', 'YoungerController@orderEntry');
});

Route::group([
    'namespace' => 'V2',
    'prefix' => 'v2'
], function () {
    Route::post('/order_entry', 'YoungerController@orderEntry');
});
