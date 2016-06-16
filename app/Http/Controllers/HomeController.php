<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class HomeController extends Controller {

    public function showLogin() {
        // show the form
        return view('login');
    }

    public function doLogin() {
// process the form
        // validate the info, create rules for the inputs
        $rules = array(
            'email' => 'required|email', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );
// run the validation rules on the inputs from the form
// if the validator fails, redirect back to the form
        // create our user data for the authentication
        
        $userdata = array(
            'email' => $_POST['email'],
            'password' => $_POST['password']
        );
        
        // attempt to do the login
//            if (Auth::attempt($userdata)) {
        if ($userdata['email'] == 'admin@admin.com' && $userdata['password'] == 'admin') {

            // validation successful!
            // redirect them to the secure section or whatever
            // return Redirect::to('secure');
            // for now we'll just echo success (even though echoing in a controller is bad)
            return redirect('/users');
        } else {
             return redirect('/login');
            
            // validation not successful, send back to form 
//            return Redirect::to('login');
        }
    }

}
