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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::group([
    'namespace' => 'Younger'
], function () {
    Route::get('/', 'YoungerController@index')->name('younger.index');
    Route::get('detail/{date}', 'YoungerController@detail')->name('younger.detail');
    Route::get('/download/{date}', 'YoungerController@download')->name('younger.download');
});
