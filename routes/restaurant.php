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


  		
 
 
Route::group(['prefix' => 'restaurant' , 'namespace' => 'Api\Restaurant'] , function(){    	

  Route::get('test' , 'AuthController@test');

Config::set('auth.defines' , 'restaurant'); 

	Route::post('register' , 'AuthController@register')->name('restaurant.register'); 
	Route::post('login' , 'AuthController@login')->name('restaurant.login'); 
    Route::post('reset-password', 'AuthController@reset');
    Route::post('new-password', 'AuthController@password');
 

	Route::group(['middleware' => 'role:restaurant'] , function(){  

		Route::get('profile' , 'AuthController@profile'); 
		Route::put('profile/update' , 'AuthController@update'); 


		Route::post('meal/create' , 'MealController@create');  





		Route::post('offer/create' , 'OfferController@create'); 
 
	});

});





