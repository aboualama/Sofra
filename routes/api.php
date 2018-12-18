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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

   	
  
Route::get('cities', 'Api\MainController@cities');
Route::get('area', 'Api\MainController@area');
Route::post('contact', 'Api\MainController@contact');
Route::get('page', 'Api\MainController@page');
Route::post('pagea', 'Api\MainController@pagea');
Route::get('setting', 'Api\MainController@setting');
Route::get('about', 'Api\MainController@about'); 
Route::get('category', 'Api\MainController@category');
Route::get('restaurants', 'Api\MainController@restaurants');
Route::get('restaurant/{id}', 'Api\MainController@restaurant');
Route::get('meals', 'Api\MainController@meals');
Route::get('meals_restaurant', 'Api\MainController@meals_restaurant');
Route::get('offers', 'Api\MainController@offers');