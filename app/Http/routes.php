<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('app');
});
//Route::get('/', array('uses' => 'HomeController@showLogin'));
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */


// Templates
Route::group(array('prefix' => '/templates/'), function() {
    Route::get('{template}', array(function($template) {
            $template = str_replace(".html", "", $template);
            View::addExtension('html', 'php');
            return View::make('templates.' . $template);
        }));
});

Route::group(['middleware' => ['web'], 'prefix' => 'admin', 'namespace' => 'admin'], function () {
    Route::get('', array('uses' => 'HomeController@showLogin'));
    Route::get('login', array('uses' => 'HomeController@showLogin'));
    Route::post('login', array('uses' => 'HomeController@doLogin'));
    Route::get('logout', array('uses' => 'HomeController@getLogout'));
});
Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'admin', 'namespace' => 'admin'], function () {
    Route::resource('users', 'UsersController');
    Route::resource('banks', 'BanksController');
    Route::resource('transferrate', 'TransferRateController');
    Route::get('profile', 'UsersController@Profile');
    Route::get('profile/edit', 'UsersController@ProfileEdit');
    Route::patch('profile/update', 'UsersController@ProfileUpdate');
    Route::get('password', 'UsersController@Password');
    Route::post('password', 'UsersController@ChangePassword');
    Route::resource('country', 'CountryController');
    Route::resource('promossion', 'PromossionController');
    Route::resource('transactions', 'TransactionController');
    Route::get('rate/list', 'CountryController@rateList');
});
// route to process the form


Route::get('gii', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate');

/*
  |--------------------------------------------------------------------------
  | API routes
  |--------------------------------------------------------------------------
 */

Route::group(['prefix' => 'api', 'namespace' => 'API'], function () {
    Route::group(['prefix' => 'v1'], function () {
        require config('infyom.laravel_generator.path.api_routes');
    });
});
