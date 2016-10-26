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
Route::get('getcurrencylist', 'CurrencyAPIController@getCurrencyList');
Route::resource('currency', 'CurrencyAPIController');
Route::post('users/login', 'UsersAPIController@login');
Route::post('users/forgotpassword', 'UsersAPIController@forgotpassword');
Route::post('users/resetpassword', 'UsersAPIController@resetpassword');
Route::resource('users', 'UsersAPIController');


Route::get('country', 'CountryAPIController@index');
Route::get('banks/{id}', 'CountryAPIController@getBanks');
Route::get('bankdetail/{id}', 'CountryAPIController@getBankDetail');
Route::post('transferrate', 'CountryAPIController@transferrate');
Route::post('transferbonus', 'CountryAPIController@transferbonus');
Route::post('checkpromossion', 'CountryAPIController@checkPromossion');
Route::post('getcountrybycurrency','CountryAPIController@getCountryByCurrency');
Route::post('documentfield', 'DocumentVerifyController@getFields');
Route::get('checkSwitch', 'DocumentVerifyController@checkSwitch');


//Route::get('successbutnotverified/{id}', 'DocverifyAPIController@documentverify');
Route::get('poli/success/{id}', 'PoliAPIController@success');
Route::get('poli/failure/{id}', 'PoliAPIController@failure');
Route::get('poli/cancelled/{id}', 'PoliAPIController@cancelled');
Route::get('poli/nudge/{id}', 'PoliAPIController@nudge');



Route::group(['middleware' => 'jwt-auth'], function () {
    Route::resource('recipient', 'RecipientAPIController');
    Route::post('checkToken', 'UsersAPIController@checkToken');
    Route::post('poliinit', 'PoliAPIController@initiatetransaction');
    Route::get('transactions', 'PoliAPIController@getTransactions');
    Route::get('transactions/get/{transactiontoken}', 'PoliAPIController@getTransactionDetail');
    Route::post('verifyDriverLicence', 'DocumentVerifyController@verifyDriverLicence');
    Route::post('verifyPassport', 'DocumentVerifyController@verifyPassport');
    Route::resource('updatProPic', 'UsersAPIController@profilePic');
});



