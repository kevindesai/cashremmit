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

class UsersAPIController extends Controller {

    public function store(Request $request) {
        $input = $request->all();

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
//        print_r($input);
//        print_r($_POST);die;
        $email = isset($input['email']) ? $input['email'] : '';
        $password = isset($input['password']) ? $input['password'] : '';
        try {
            $user = User::where('email', $email)->first();
        } catch (Exception $e) {
            
        }
//        print_r($user->toArray());
        $response = [
                'status' => 0,
                'message' => 'invalid username or password'
            ];
        if (isset($user) && $user) {
            $response = [
                'status' => 1,
                'message' => 'Login successful',
                'data' => $user->toArray()
            ];
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
        $user->update($request->all());
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
