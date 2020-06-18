<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/chunk_upload', 'ChunkUploadController@chunkTest');

Route::middleware('auth:api')->post('/chunk_upload', 'ChunkUploadController@chunkStore');

Route::post('/load_vm', 'VMVisorController@loadVM');

Route::post('/poll_vm', 'VMVisorController@poll');

Route::post('/mqtt/publish', 'VMVisorController@MqttTest');

Route::post('/flag/rotate', 'FlagController@rotateFlag');

Route::get('/mqttsub', 'FlagController@mqttSubTest');
