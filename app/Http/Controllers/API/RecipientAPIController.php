<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\API;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\RecipientMaster;
use Session;
use Response;
use Validator;
use Exception;

class RecipientAPIController extends Controller {

    public function store(Request $request) {
        $input = $request->all();
        $validation = Validator::make(
                        $request->all(), array(
                    'first_name' => array('required', 'alpha_dash'),
                    'last_name' => array('required', 'alpha_dash'),
                    'city_name' => array('required'),
                    'country_name' => array('required'),
                    'bank_name' => array('required'),
                    'account_number' => array('required'),
                    'bank_code' => array('required'),
                    'user_id' => array('required', 'exists:users,id'),
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
        $user = RecipientMaster::create($input);

        if ($user) {
            $response = array(
                'status' => '1',
                'data' => $user->toArray(),
                'message' => 'Recipient added successfully'
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

    public function index() {

        $users = RecipientMaster::paginate(15);
//        return view('users.index', compact('users'));
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
        $recipients = RecipientMaster::where('user_id', $id)->orderBy('id', 'desc')->get();
        $response = array(
            'status' => '0',
            'message' => 'No data found'
        );
        $recipients = $recipients->toArray();
        if (!empty($recipients)) {
            $response = array(
                'status' => '1',
                'message' => 'data found',
                'data'=>$recipients
            );
        }
        echo json_encode($response);
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
        $recipient = RecipientMaster::findOrFail($id);
        $inputs = $request->all();

        $validation = Validator::make(
                        $request->all(), array(
                    'first_name' => array('required', 'alpha_dash'),
                    'last_name' => array('required', 'alpha_dash'),
                    'city_name' => array('required'),
                    'country_name' => array('required'),
                    'bank_name' => array('required'),
                    'account_number' => array('required'),
                    'bank_code' => array('required'),
                    'user_id' => array('required', 'exists:users,id'),
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

        $recipient->update($inputs);
        if ($recipient) {
            $response = array(
                'status' => '1',
                'data' => $recipient->toArray(),
                'message' => 'Recipient updated successfully'
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
        $response = array(
            'status' => '0',
            'message' => 'Not deleted, Try again letter.'
        );
        if (RecipientMaster::destroy($id)) {
            $response = array(
                'status' => '1',
                'message' => 'Deleted successfully'
            );
        }
        return json_encode($response);


        return redirect('users');
    }

}
