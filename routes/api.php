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

Route::post('/user', [
    'uses'  => 'AuthController@register'
]);

Route::post('user/signin', [
    'uses'  => 'AuthController@signin'
]);

Route::post('behavior', [
    'uses' => 'BehaviorController@postBehavior',
    'middleware' => 'jwt.auth'
]);

Route::get('behaviors', [
    'uses' => 'BehaviorController@getAllBehaviors',
    'middleware' => 'jwt.auth'
]);

Route::get('behavior/{behavior}', [
    'uses' => 'BehaviorController@getBehavior',
    'middleware' => 'jwt.auth'
]);

Route::put('behavior/{behavior}', [
    'uses' => 'BehaviorController@updateBehavior',
    'middleware' => 'jwt.auth'
]);

Route::delete('behavior/{behavior}', [
    'uses' => 'BehaviorController@deleteBehavior',
    'middleware' => 'jwt.auth'
]);