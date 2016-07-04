<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Response;
use Validator;

class UsersAPIController extends Controller {

    public function store(Request $request) {
        $input = $request->all();

        $validation = Validator::make(
                        $request->all(), array(
                    'first_name' => array('required', 'alpha_dash'),
                    'last_name' => array('required', 'alpha_dash'),
                    'email' => array('required', 'email','unique:users'),
//                    'city' => array('required'),
//                    'post_code' => array('required'),
//                    'country' => array('required'),
                    'password' => array('required'),
                        )
        );
        $data = array();
        if ($validation->fails()) {
            $response = array(
                'status' => '0',
                'data' => $validation->messages(),
                'message' => 'Validation error'
            );
            return json_encode($response);
             
        }
        $input = $request->all();
        if (isset($input['password'])) {
            $input['password'] = base64_encode($input['password']);
        }
        $user = User::create($input);

        if ($user) {
            $response = array(
                'status' => '1',
                'data' => $user->toArray(),
                'message' => 'User registered successfully'
            );
        } else {
            $response = array(
                'status' => '0',
                'data' => array(),
                'message' => 'Some error occurs,try again letter.'
            );
        }
        return json_encode($response);
//        return $this->sendResponse($user->toArray(), 'User registered successfully');
    }

    public function login(Request $request) {
        $input = $request->all();
        $email = isset($input['email']) ? $input['email'] : '';
        $password = isset($input['password']) ? $input['password'] : '';
        try {
            $user = User::where('email', $email)->first();
        } catch (Exception $e) {
            
        }
        $response = [
            'status' => 0,
            'message' => 'Username does not exist'
        ];
        if (isset($user) && $user) {
            if (base64_decode($user->password) == $password) {
                $response = [
                    'status' => 1,
                    'message' => 'Login successful',
                    'data' => $user->toArray()
                ];
            } else {
                $response = [
                    'status' => 0,
                    'message' => 'Invalid password'
                ];
            }
        }
        return json_encode($response);
    }

    public function index() {

        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {
        return view('users.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id) {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id) {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request) {
        $user = User::findOrFail($id);
        $inputs = $request->all();
        if (isset($inputs['password'])) {
            $inputs['password'] = base64_encode($inputs['password']);
        }
        $user->update($inputs);
        if ($user) {
            $response = array(
                'status' => '1',
                'data' => $user->toArray(),
                'message' => 'User updated successfully'
            );
        } else {
            $response = array(
                'status' => '0',
                'data' => array(),
                'message' => 'Some error occurs,try again letter.'
            );
        }
        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id) {
        User::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect('users');
    }

}
