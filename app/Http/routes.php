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

/* Login Form */
Route::get('/login', function () {
	return view('auth.login');
});


/* Validate Login Creds */
Route::post('/authenticate', 'Auth\AuthController@checkLogin');


/* User Register Form */
Route::get('/register', function () {
	return view('auth.register');
});

/* Creates a New User */
Route::post('/createuser', 'Auth\AuthController@createUser');    


/* Log out */
Route::get('/logout', 'Auth\AuthController@logout');


/* List of Currencies available */

Route::get('/currency-list', 'CurrencyController@getCurrencyList');

/* Currency converter Screen */	
Route::get('/currency-converter', 'CurrencyController@getCurrencyConverterList');

/* to get Conversion factor */
Route::get('/conversion-factor', 'CurrencyController@getConversionFactor');


/* new currency creation form */
Route::get('/add-currency', 'CurrencyController@getCurrencyListView');

/* creating a new currency in db */
Route::post('/post-currency', 'CurrencyController@addCurrency');

/* editing currency details form */
Route::get('/currency-edit-form/{id}', 'CurrencyController@getCurrencyDetailsById');

/* submiting the new values */
Route::post('/currency-edit', 'CurrencyController@updateCurrencyConversionById');

Route::get('/currency-toggle/{id}/{status}', 'CurrencyController@toggleCurrencyConversionById');
