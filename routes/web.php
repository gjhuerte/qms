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

Route::prefix('queue')->group(function(){
	Route::get('/', 'QueuesController@index' );

	Route::get('generate', 'QueuesController@showGenerateForm');
	Route::post('generate', 'QueuesController@generate');

	Route::get('attend','QueuesController@showAttendForm');
	Route::post('attend','QueuesController@attend');

	Route::get('cancel','QueuesController@cancel');

	Route::get('counter','QueuesController@showCounter');

	Route::get('list','QueuesController@showList');
	Route::post('call','QueuesController@call');

	Route::get('{id}/print','QueuesController@printVoucher');
});

Route::prefix(config('backpack.base.route_prefix'))->group(function(){
	Route::get('dashboard', 'AdminController@dashboard');
});
 
Route::get('socket', 'SocketController@index');
Route::post('sendmessage', 'SocketController@sendMessage');
Route::get('writemessage', 'SocketController@writemessage');