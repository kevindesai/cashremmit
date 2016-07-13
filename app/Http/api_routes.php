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

Route::group(['middleware' => 'jwt-auth'], function () {
    Route::resource('recipient', 'RecipientAPIController');
});


