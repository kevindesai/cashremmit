<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/

Route::resource('users', 'UsersAPIController');
Route::resource('recipient', 'RecipientAPIController');
Route::post('users/login', 'UsersAPIController@login');
Route::post('currency/convert', 'CurrencyAPIController@convert');
