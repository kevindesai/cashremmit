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
use App\UserDocument;

class DocumentVerifyController extends Api {

    private $_auth;

    public function getFields(Request $request) {
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
            foreach ($docfields as $fields) {
                $dataArr[] = array("id" => $fields["id"], "country_id" => $fields["country_id"], "name" => $fields["name"], "attributes" => json_decode($fields["attributes"]), "created_at" => $fields["created_at"], "updated_at" => $fields["updated_at"]);
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

    public function verifyDriverLicence(Request $request) {
        $this->_auth = JWTAuth::toUser(JWTAuth::getToken());
        $inputs = $request->all();
        $params = array(
            'AcceptTruliooTermsAndConditions' => true,
            'Demo' => true,
            'CleansedAddress' => true,
            'ConsentForDataSources' => array(
                'Australia Driver Licence'
            ),
            'CountryCode' => 'AU',
            'DataFields' => array(
                'PersonInfo' => array(
                    'FirstGivenName' => isset($inputs['FirstGivenName']) ? $inputs['FirstGivenName'] : '',
                    'MiddleName' => isset($inputs['MiddleName']) ? $inputs['MiddleName'] : '',
                    'FirstSurName' => isset($inputs['FirstSurName']) ? $inputs['FirstSurName'] : '',
                    'SecondSurname' => isset($inputs['SecondSurname']) ? $inputs['SecondSurname'] : '',
                    'ISOLatin1Name' => isset($inputs['ISOLatin1Name']) ? $inputs['ISOLatin1Name'] : '',
                    'DayOfBirth' => isset($inputs['DayOfBirth']) ? $inputs['DayOfBirth'] : '',
                    'MonthOfBirth' => isset($inputs['MonthOfBirth']) ? $inputs['MonthOfBirth'] : '',
                    'YearOfBirth' => isset($inputs['YearOfBirth']) ? $inputs['YearOfBirth'] : '',
                    'MinimumAge' => 1,
                    'Gender' => isset($inputs['Gender']) ? $inputs['Gender'] : '',
                    'AdditionalFields' => array(
                        'FullName' => '',
                    )
                ),
                'DriverLicence' => array(
                    'Number' => isset($inputs['Number']) ? $inputs['Number'] : '',
                    'State' => isset($inputs['State']) ? $inputs['State'] : '',
                    'DayOfExpiry' => isset($inputs['DayOfExpiry']) ? $inputs['DayOfExpiry'] : '',
                    'MonthOfExpiry' => isset($inputs['MonthOfExpiry']) ? $inputs['MonthOfExpiry'] : '',
                    'YearOfExpiry' => isset($inputs['YearOfExpiry']) ? $inputs['YearOfExpiry'] : ''
                )
            )
        );
        $raw = json_encode($params);
        $resp = $this->callAPI($raw);

        $response = array(
            'status' => 0
        );
        if ($resp->Record->RecordStatus == 'match') {
            $response['status'] = 1;
            $UD = array(
                'user_id' => $this->_auth->id,
                'doc_type' => 'DriverLicence',
                'attributes' => $raw
            );
            $userDocCheck = UserDocument::where('user_id', $this->_auth->id)->first();
            if (!$userDocCheck) {
                $userDoc = UserDocument::create($UD);
                ;
            } else {
                $userDocCheck->update($UD);
            }
            $user = User::find($this->_auth->id);
            $user->is_verified = 1;
            $user->update();
        }
        echo json_encode($response);
    }

    public function verifyPassport(Request $request) {
        $this->_auth = JWTAuth::toUser(JWTAuth::getToken());
        $inputs = $request->all();
        $params = array(
            'AcceptTruliooTermsAndConditions' => true,
            'Demo' => true,
            'CleansedAddress' => true,
            'ConsentForDataSources' => array(
            ),
            'CountryCode' => 'AU',
            'DataFields' => array(
                'PersonInfo' => array(
                    'FirstGivenName' => isset($inputs['FirstGivenName']) ? $inputs['FirstGivenName'] : '',
                    'MiddleName' => isset($inputs['MiddleName']) ? $inputs['MiddleName'] : '',
                    'FirstSurName' => isset($inputs['FirstSurName']) ? $inputs['FirstSurName'] : '',
                    'SecondSurname' => isset($inputs['SecondSurname']) ? $inputs['SecondSurname'] : '',
                    'ISOLatin1Name' => isset($inputs['ISOLatin1Name']) ? $inputs['ISOLatin1Name'] : '',
                    'DayOfBirth' => isset($inputs['DayOfBirth']) ? $inputs['DayOfBirth'] : '',
                    'MonthOfBirth' => isset($inputs['MonthOfBirth']) ? $inputs['MonthOfBirth'] : '',
                    'YearOfBirth' => isset($inputs['YearOfBirth']) ? $inputs['YearOfBirth'] : '',
                    'MinimumAge' => 1,
                    'Gender' => isset($inputs['Gender']) ? $inputs['Gender'] : '',
                    'AdditionalFields' => array(
                        'FullName' => '',
                    )
                ),
                'Passport' => array(
                    'Mrz1' => isset($inputs['Mrz1']) ? $inputs['Mrz1'] : '',
                    'Mrz2' => isset($inputs['Number']) ? $inputs['Mrz2'] : '',
                    'Number' => isset($inputs['Number']) ? $inputs['Number'] : '',
                    'DayOfExpiry' => isset($inputs['DayOfExpiry']) ? $inputs['DayOfExpiry'] : '',
                    'MonthOfExpiry' => isset($inputs['MonthOfExpiry']) ? $inputs['MonthOfExpiry'] : '',
                    'YearOfExpiry' => isset($inputs['YearOfExpiry']) ? $inputs['YearOfExpiry'] : ''
                )
            )
        );
        $raw = json_encode($params);

        $resp = $this->callAPI($raw);
//        print_r($resp);die;
        $response = array(
            'status' => 0
        );
        if ($resp->Record->RecordStatus == 'match') {
            $response['status'] = 1;
            $UD = array(
                'user_id' => $this->_auth->id,
                'doc_type' => 'Passport',
                'attributes' => $raw
            );
            $userDocCheck = UserDocument::where('user_id', $this->_auth->id)->first();
            if (!$userDocCheck) {
                $userDoc = UserDocument::create($UD);
                ;
            } else {
                $userDocCheck->update($UD);
            }
            $user = User::find($this->_auth->id);
            $user->is_verified = 1;
            $user->update();
        }
        echo json_encode($response);
    }

    public function callAPI($raw) {
        $header = array();
        $header[] = 'Content-Type: application/json';
        $header[] = 'Authorization: Basic Q2FzaFJlbWl0X0RlbW9fQVBJOkFkbWluQElUMjAxNg==';
        $publicPath = public_path();
        $ch = curl_init("https://api.globaldatacompany.com/verifications/v1/verify");
        curl_setopt($ch, CURLOPT_CAINFO, $publicPath . "/ca-bundle.crt");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $raw);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);
        return $resp = json_decode($res);
    }

    public function checkSwitch() {
        ini_set('soap.wsdl_cache_enabled', 0);
        ini_set('soap.wsdl_cache_ttl', 900);
        ini_set('default_socket_timeout', 15);

        echo "This is request<br />";
        echo $input_xml = '
                <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                <FundGate>
                    <direction>request</direction>
                    <action>FT</action>
                    <terminalId>20000000054</terminalId>
                    <transaction>
                        <pin>' . $this->encPin('0012') . '</pin>
                        <bankCode>033</bankCode>
                        <amount>10.0</amount>
                        <destination>2001220212</destination>
                        <reference>2422332324233242</reference>
                        <endPoint>A</endPoint>
                    </transaction>
                </FundGate>';

        $wsdl = public_path() . '/staging_doc.wsdl';

        $options = array(
            'uri' => 'http://demo.etranzact.com/FundGateWSDL/doc.wsdl',
            'trace' => true,
            'exceptions' => true,
        );
        try {
            $soap = new \SoapClient($wsdl, $options);
            $data = $soap->__soapCall("process", array("FundRequest" => $input_xml));
//            $data = $soap->process(array("FundRequest"=>$input_xml));
        } catch (Exception $e) {
            die($e->getMessage());
        }
        echo "This is response<br />";
        echo "<pre>";
        print_r($data);
//var_dump($data);
        die;
    }

    public function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function encPin($pin) {
        $master_key = substr('KEd4gDNSDdMBxCGliZaC8w==', 0, 16);
//        $master_key = 'KEd4gDNSDdMBxCGliZaC8w==';

        $pin = $this->pkcs5_pad($pin, 16);

        $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($cipher, $master_key, $master_key);
        $encrypted = mcrypt_generic($cipher, $pin);

        return base64_encode($encrypted);
    }

}
