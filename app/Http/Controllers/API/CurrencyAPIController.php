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
use Session;
use Response;
use Validator;
use Exception;
class CurrencyAPIController extends Controller {

    public function Convert(Request $request) {
        $input = $request->all();
        $validation = Validator::make(
                        $input, array(
                    'amount' => array('required'),
                    'to' => array('required'),
                    'from' => array('required'),
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
        foreach ($input as $k => $v)
            $$k = $v;
        try {
            $data = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from&to=$to");
            preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
            if (isset($converted[1]))
                $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
            else
                throw new Exception("Error");
                $response = array(
                'status' => '1',
                'original' => number_format(round($amount, 3), 2),
                'converted' => number_format(round($converted, 3), 2),
                'message' => 'Success'
            );
        } catch (Exception $e) {
            $response = array(
                'status' => '0',
                'original' => number_format(round($amount, 3), 2),
                'converted' => number_format(round(0, 3), 2),
                'message' => 'Not Converted'
            );
        }
//        return number_format(round($converted, 3), 2);

        return json_encode($response);
    }

}
