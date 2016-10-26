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
use JWTAuth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use \Crypt;

class UsersAPIController extends Controller {

    public function checkToken() {
        $array = array(
            'status' => '1',
            'message' => 'valid token',
        );
        return json_encode($array);
    }

    public function store(Request $request) {
        $input = $request->all();
        if ($input["from"] == "register") {
            $validation = Validator::make(
                            $request->all(), array(
                        'first_name' => array('required', 'alpha_dash'),
                        'last_name' => array('required', 'alpha_dash'),
                        'email' => array('required', 'email', 'unique:users'),
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
            $input['is_active'] = 1;
            $input['is_verified'] = 0;
            if (isset($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            }
            $user = User::create($input);

            if ($user) {
                try {
                    Mail::send('emails.welcomeEmail', array("user" => $user), function ($message) use ($user) {

                        $message->from('support@cashremit.com.au', 'Cash Remit');

                        $message->to($user->email)->subject('Welcome to Cashremit');
                    });
                } catch (Exception $e) {
                    
                }



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
        } else {

            $validation = Validator::make(
                            $request->all(), array(
                        'first_name' => array('required', 'alpha_dash'),
                        'last_name' => array('required', 'alpha_dash'),
                        'email' => array('required', 'email'),
                            )
            );
            if ($validation->fails()) {
                $response = array(
                    'status' => '0',
                    'data' => $validation->messages(),
                    'message' => 'Validation error'
                );
                return json_encode($response);
            }
            try {
                $user = User::where('social_id', $input["social_id"])->first();
            } catch (Exception $e) {
                
            }
            if (isset($user) && $user) {
                $response = array(
                    'status' => '2',
                    'data' => $user->toArray(),
                    'message' => 'User registered successfully'
                );
            } else {
                $input['is_active'] = 1;
                $input['is_verified'] = 0;
                $input['password'] = 123456;
                if (isset($input['password'])) {
                    $input['password'] = Hash::make($input['password']);
                }
                $user = User::create($input);

                if ($user) {
                    try {
                        Mail::send('emails.welcomeEmail', array("user" => $user), function ($message) use ($user) {

                            $message->from('support@cashremit.com.au', 'Cash Remit');

                            $message->to($user->email)->subject('Welcome to Cashremit');
                        });
                    } catch (Exception $e) {
                        
                    }



                    $response = array(
                        'status' => '2',
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
            }
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
            Config::set('auth.providers.users.table', 'users');
            if ($token = JWTAuth::attempt($input)) {

                $data = $user->toArray();
                $data["profile"] = ($data["profile"] != "") ? URL('/storage/uploads/user/') . "/" . $data["profile"] : URL('/storage/uploads/user/') . "/" . "default.jpg";
                $data['customer_id'] = User::getCustomerID($user->id);
                $data['country_name'] = isset($user->countries->country_name) ? $user->countries->country_name : '';
                $data['country_code'] = isset($user->countries->country_code) ? $user->countries->country_code : '';
                $data['country_id'] = isset($user->countries->id) ? $user->countries->id : '';

                $response = [
                    'status' => 1,
                    'message' => 'Login successful',
                    'data' => $data,
                    'token' => $token
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
            $inputs['password'] = Hash::make($inputs['password']);
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

    public function profilePic(request $request) {
        $this->_auth = JWTAuth::toUser(JWTAuth::getToken());
        $userId = $this->_auth->id;

        $fileName = $_FILES["file"]["name"];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileTmpName = $_FILES["file"]["tmp_name"];
        $newFileName = time() . rand(99, 999999);
        $newName = $newFileName . '.' . $ext;
        $destinationPath = storage_path() . '/uploads/user/';
        if (move_uploaded_file($fileTmpName, $destinationPath . $newName)) {
            $userData = \App\User::find($userId);
            $userData->profile = $newName;
            $userData->save();
            $response = array(
                "status" => "1",
                "data" => URL('/storage/uploads/user/') . "/" . $newName,
                "message" => "Profile picture uploaded successfully"
            );
        } else {
            $response = array(
                "status" => "0",
                "data" => "",
                "message" => "Please try again."
            );
        }
        return json_encode($response);
    }

    public function forgotpassword(request $request) {
        $input = $request->all();
        $email = isset($input['email']) ? $input['email'] : '';
        if ($email != "") {
            try {
                $user = User::where('email', $email)->first();
            } catch (Exception $e) {
                
            }
            $response = [
                'status' => 0,
                'message' => 'Email does not exist'
            ];
            if (isset($user) && $user) {
                $token = base64_encode($email.'/-/'.date("Y-m-d H:i:s"));
                $token = Crypt::encrypt($email);
                //echo  Crypt::decrypt($token);
                
                $emailLink = URL("/#/")."/forgot/".$token;
                
                $userData = $user->toArray();
                
                $data = [
                    "user"=>$userData,
                    "emailLink" =>$emailLink
                ];
                try {
                        Mail::send('emails.forgotPwd', array("data" => $data), function ($message) use ($data) {

                            $message->from('support@cashremit.com.au', 'Cash Remit');

                            $message->to($data["user"]["email"])->subject('Forgot Password');
                        });
                    } catch (Exception $e) {
                        
                    }
                $response = [
                'status' => 1,
                'message' => 'Email Sent Successfully.'
            ];    
            }
        } else {
            $response = array(
                "status" => "0",
                "data" => "",
                "message" => "Email can not be blank"
            );
        }
        return json_encode($response);
    }
    
    public function resetpassword(request $request){
        $input = $request->all();
        $token = isset($input['token']) ? $input['token'] : '';
        $password = isset($input['password']) ? $input['password'] : '';
        if($token != "" && $password != ""){
            try{
                $email = Crypt::decrypt($token);
                $user = User::where('email', $email)->first();
                if($user && !empty($user)){
                    $user->password = Hash::make($input['password']);
                    $user->save();
                    $response = array(
                            "status" => "1",
                            "data" => "",
                            "message" => "Password changed successfully."
                        );
                }else{
                    $response = array(
                "status" => "0",
                "data" => "",
                "message" => "Something went wrong please try again."
            );
                }
            }catch(Exception $e){
                
            }
        }else{
            $response = array(
                "status" => "0",
                "data" => "",
                "message" => "Something went wrong please try again."
            );
        }
        return json_encode($response);
    }

}
