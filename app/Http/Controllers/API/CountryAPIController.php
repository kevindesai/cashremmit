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
use Validator;
use App\Country;
use App\Currencyrate;
use App\Bank;

class CountryAPIController extends Controller {

    public function index() {
        $country = Country::all();
        $response = array(
            'status' => '0',
            'message' => 'No data found'
        );
        $country = $country->toArray();
        if (!empty($country)) {
            $response = array(
                'status' => '1',
                'message' => 'data found',
                'data' => $country
            );
        }
        return json_encode($response);
    }

    public function getBanks($id) {
        $banks = Bank::where('country_id', $id)->get();
        $response = array(
            'status' => '0',
            'message' => 'No data found'
        );
        $banks = $banks->toArray();
        if (!empty($banks)) {
            
            $response = array(
                'status' => '1',
                'message' => 'data found',
                'data' => $banks
            );
        }
        return json_encode($response);
    }
    public function getBankDetail($id) {
        
        $banks = Bank::find($id);
        $response = array(
            'status' => '0',
            'message' => 'No data found'
        );
        
        $banks = $banks->toArray();
        if (!empty($banks)) {
            if(is_array(json_decode($banks['attributes'], true))){
                $banks['attributes'] = json_decode($banks['attributes'], true);
            }else{
                $banks['attributes'] = [];
            }
            $response = array(
                'status' => '1',
                'message' => 'data found',
                'data' => $banks
            );
        }
        return json_encode($response);
    }

}
