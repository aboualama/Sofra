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
Route::pattern('id', '[0-9]+');
 
 
Route::group(['prefix' => 'client' , 'namespace' => 'Api\Client'] , function(){    	
  
  // Route::get('test' , function () { return 'client' ; });

  // Config::set('auth.defines' , 'client'); 

	Route::post('register' , 'AuthController@register')->name('client.register'); 
	Route::post('login' , 'AuthController@login')->name('client.login'); 
    Route::post('reset-password', 'AuthController@reset');
    Route::post('new-password', 'AuthController@password');
 

	Route::group(['middleware' => 'role:client'] , function(){  

		Route::get('profile' , 'AuthController@profile'); 
		Route::put('profile/update' , 'AuthController@update'); 
 
	});

});

 