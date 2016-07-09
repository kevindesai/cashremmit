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
use Illuminate\Support\Facades\DB;
use App\Country;
use Response;
use Validator;
use Exception;
use App\Currencyrate;

class CurrencyAPIController extends Controller {

    /**
     *      Import CSV
     */
    public function index() {
        DB::table('country')->truncate();
        $csvFile = public_path() . '/country-list.csv';
        $cList = Country::csv_to_array($csvFile);
        DB::table('country')->insert($cList);
        echo "<pre>";
        print_r($cList);

        // Uncomment the below to run the seeder
//        DB::table('books')->insert($areas);
    }

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
            
            $curRate = Currencyrate::where(['to' => $input['to'], 'from' => $input['from']])->first();
            
            if($curRate && !isset($input['web']))
                $converted += $curRate->rate*$amount;
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
