<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});






Route::group(['middleware' => 'web'], function () {

	Route::auth();

	Route::get('/register', function () {
		return view('auth.register');
	});

	Route::get('/login', function () {
    	return view('auth.login');
	});

	//Route::get('/logout', 'Auth\AuthController@logout');

	Route::post('/authenticate', 'Auth\AuthController@checkLogin');
	Route::post('/createuser', 'Auth\AuthController@createUser');    
	
	Route::get('/currency-converter', 'CurrencyController@getCurrencyList');
	Route::post('/currency-converter', 'CurrencyController@convertCurrency');
	Route::get('/conversion-factor', 'CurrencyController@getConversionFactor');
	

});




