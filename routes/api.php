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
Route::group(['middleware' => ['auth:api']], function() {
    Route::post('helloworld/{name}', "HelloWorld\V1\HelloWorldController@create");
    Route::get('helloworld', "HelloWorld\V1\HelloWorldController@fetch");
    Route::get('helloworld/trashed', "HelloWorld\V1\HelloWorldController@trashed");
    Route::get('helloworld/active', "HelloWorld\V1\HelloWorldController@active");
    Route::put('helloworld/{id}/{name}', "HelloWorld\V1\HelloWorldController@update");
    Route::patch('helloworld/{id}', "HelloWorld\V1\HelloWorldController@restore");
    Route::delete('helloworld/{id}', "HelloWorld\V1\HelloWorldController@delete");
});
