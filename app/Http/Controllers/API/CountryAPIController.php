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
use App\TransferRate;
use App\Promossion;
use App\TransferBonus;

class CountryAPIController extends Controller {

    public function transferrate(Request $request) {
        $inputs = $request->all();
        $transferrate = TransferRate::whereHas('country', function($q) use($inputs) {
                    $q->where(['country.country_name' => $inputs['country_name'], 'country.currency_code' => $inputs['currency_code']]);
                })->where('from', '<=', (float) $inputs['amount'])->where('to', '>=', (float) $inputs['amount'])->first();
        $response = [
            'status' => 1,
            'transfer_rate' => 0
        ];
        if ($transferrate) {
            $response = [
                'status' => 1,
                'transfer_rate' => $transferrate->rate
            ];
        }
        return json_encode($response);
    }
    public function transferbonus(Request $request) {
        $inputs = $request->all();
        $transferrate = TransferBonus::whereHas('country', function($q) use($inputs) {
                    $q->where(['country.currency_code' => $inputs['currency_code']]);
                })->where('from', '<=', (float) $inputs['amount'])->where('to', '>=', (float) $inputs['amount'])->first();
        $response = [
            'status' => 0,
            'transfer_rate' => 0
        ];
        if ($transferrate) {
            $response = [
                'status' => 1,
                'transfer_rate' => number_format($transferrate->rate, 2, '.', '')
            ];
        }
        return json_encode($response);
    }

    public function checkPromossion(Request $request) {
        $inputs = $request->all();
        $promossion = Promossion::where(['code' => $inputs['code']])->first();
        $response = [
            'status' => 0,
            'discount' => 0,
            'message' => 'invalid'
        ];
        if ($promossion) {
            
            if ($promossion->is_enable == '1') {
                $response = [
                    'status' => 1,
                    'discount' => $promossion->discount,
                    'message' => 'valid'
                ];
            } else {
                $response = [
                    'status' => 0,
                    'discount' => 0,
                    'message' => 'expired'
                ];
            }
        }
        return json_encode($response);
    }

    public function index() {
        $country = Country::where(['status'=>'1'])->get();
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
            if (is_array(json_decode($banks['attributes'], true))) {
                $banks['attributes'] = json_decode($banks['attributes'], true);
            } else {
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
    public function getCountryByCurrency(Request $request){
        $inputs = $request->all();
        $countries = Country::where(array("currency_code"=>$inputs["currency_code"]))->get();
        if(!empty($countries)){
            $countries = $countries->toArray();
        $response = array(
                'status' => '1',
                'message' => 'data found',
                'data' => $countries
            );
        
        }else{
            $response = array(
            'status' => '0',
            'message' => 'No data found'
        );
        }
         return json_encode($response);
    }

}
