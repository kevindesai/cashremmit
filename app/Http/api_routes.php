<?php

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where all API routes are defined.
  |
 */
Route::post('currency/convert', 'CurrencyAPIController@convert');
Route::resource('currency', 'CurrencyAPIController');
Route::post('users/login', 'UsersAPIController@login');
Route::resource('users', 'UsersAPIController');

Route::get('country', 'CountryAPIController@index');
Route::get('banks/{id}', 'CountryAPIController@getBanks');
Route::get('bankdetail/{id}', 'CountryAPIController@getBankDetail');
Route::post('transferrate', 'CountryAPIController@transferrate');
Route::post('checkpromossion', 'CountryAPIController@checkPromossion');
Route::post('getcountrybycurrency','CountryAPIController@getCountryByCurrency');


Route::get('poli/success/{id}', 'PoliAPIController@success');
Route::get('poli/failure/{id}', 'PoliAPIController@failure');
Route::get('poli/cancelled/{id}', 'PoliAPIController@cancelled');
Route::get('poli/nudge/{id}', 'PoliAPIController@nudge');

Route::group(['middleware' => 'jwt-auth'], function () {
    Route::resource('recipient', 'RecipientAPIController');
    Route::post('poliinit', 'PoliAPIController@initiatetransaction');
    Route::get('transactions', 'PoliAPIController@getTransactions');
});


