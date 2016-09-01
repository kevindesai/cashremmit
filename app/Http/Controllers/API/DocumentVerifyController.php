<?php

namespace App\Http\Controllers\API;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


use App\Http\Requests;
use App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Documents;
use Session;
use Response;
use Validator;
use Exception;
use JWTAuth;
use Mail;
use Aloha\Twilio\Facades\Twilio as Twilio;

class DocumentVerifyController extends Api {

    private $_auth;


    
    public function getFields(Request $request){
        $inputs = $request->all();
        $country_id = $inputs["country_id"];
        $docfields = Documents::where('country_id', $country_id)->orderBy('id', 'desc')->get();
        $response = array(
            'status' => '0',
            'message' => 'No data found'
        );
        $docfields = $docfields->toArray();
        $dataArr = array();
        
        if (!empty($docfields)) {
            foreach($docfields as $fields){
                $dataArr[] = array("id"=>$fields["id"],"country_id"=>$fields["country_id"],"name"=>$fields["name"],"attributes"=>  json_decode($fields["attributes"]),"created_at"=>$fields["created_at"],"updated_at"=>$fields["updated_at"]);
            }
            
            $response = array(
                'status' => '1',
                'message' => 'data found',
                'data' => $dataArr
            );
            
        }
        
        echo json_encode($response);
        exit;
    }
}
