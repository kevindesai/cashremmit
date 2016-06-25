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



class UsersAPIController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();

        $user = User::create($input);

        if($user){
            $response = array(
                'status'=>'1',
                'data'=>$user->toArray(),
                'message'=>'User registered successfully'
            );
        }else{
            $response = array(
                'status'=>'0',
                'data'=>array(),
                'message'=>'Some error occurs,try again letter.'
            );
        }
        return json_encode($response);
//        return $this->sendResponse($user->toArray(), 'User registered successfully');
    }
}
