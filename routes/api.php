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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () {
    Route::resource('meeting', 'MeetingController', [
        //edit and create: These routes aren't needed as no webpages are being displayed with the API
        'except' => ['edit', 'create']
    ]);
    
    Route::resource('meeting/registration', 'RegistrationController', [
        //store and destroy: the only routes needed as you can either register (store) or unregister (destroy)
        'only' => ['store', 'destroy']
    ]);
    
    // POST Routes to handle actions for users of the API
    Route::post('user', [
        'uses' => 'AuthController@store'
    ]);
    
    Route::post('user/signin', [
        'uses' => 'AuthController@signin'
    ]);
});


