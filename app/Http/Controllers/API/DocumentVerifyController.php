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
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use Flutterwave\Disbursement;
use Flutterwave\Flutterwave;
use Flutterwave\Countries;
use Flutterwave\Currencies;

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
        //$header[] = 'Authorization: Basic Q2FzaFJlbWl0X1BvcnRhbDpjI2tJYlIzcmYpI0g6NSMsKg==';
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
        $merchantKey = "tk_Hqc328yY00"; //can be found on flutterwave dev portal
        $apiKey = "tk_KB32cAk5E04LaHWYqRso"; //can be found on flutterwave dev portal
        $env = "staging"; //this can be production when ready for deployment
        Flutterwave::setMerchantCredentials($merchantKey, $apiKey, $env);

//In order to disburse funds, you need to first link the account you will disburse from
//You can link as many accounts as you want
        $accountno = "0690000031";
        $result = Disbursement::link($accountno);
//$result is an instance of ApiResponse class which has
//methods like getResponseData(), getStatusCode(), getResponseCode(), isSuccessfulResponse()

        if ($result->isSuccessfulResponse()) {
//            echo("I have successfully linked an account.");
//            echo "<br/>";
        }

//After linking an account, you need to do double validation of that linked account
//This is to authenticate that the account belongs to you
        $response = $result->getResponseData();
        $linkingRef = $response['data']['uniquereference'];

//Validation Step 1
        $otp = "1.00";
        $otpType = "ACCOUNT_DEBIT"; //(ACCOUNT_DEBIT | PHONE_OTP)
        $result2 = Disbursement::validate($otp, $linkingRef, $otpType);
        $response2 = $result2->getResponseData();

        if ($result2->isSuccessfulResponse()) {
//            echo("I have passed first validation test.");
//            echo "<br/>";
        }

//Validation Step 2
//This will return an account token if successful
        $otp = "12345";
        $otpType = "PHONE_OTP"; //(ACCOUNT_DEBIT | PHONE_OTP)
        $result3 = Disbursement::validate($otp, $linkingRef, $otpType);
        $response3 = $result3->getResponseData();

        if ($result3->isSuccessfulResponse()) {
//            echo("I have passed second validation test.");
//            echo "<br/>";
        }

//If Validation step 2 is successful, an account token is returned, you save the account token
//You will need the account token each time you want to disburse funds
        $accountToken = $response3['data']['accounttoken'];
        $amount = 101;
        $uniqueRef = "23323234547871232-11"; //This reference has to be unique
        $senderName = "Godswill Okwara";
        $destination = [
            "country" => Countries::NIGERIA,
            "currency" => Currencies::NAIRA,
            "bankCode" => "044", //the 044 represents the bank code, you can get all bank codes using the bank API
            "recipientAccount" => "0690000028", //Make sure you havent added this account before
            "recipientName" => "Ridwan Olalere"
        ];
        $narration = "Testing Sanket";
        $result4 = Disbursement::send($accountToken, $uniqueRef, $amount, $narration, $senderName, $destination);
        $response4 = $result4->getResponseData();

        if ($result4->isSuccessfulResponse()) {
            echo("I have successfully disbursed funds.");
            echo "<br/>";
            echo "<pre>";
            print_r($result4);
            echo "</pre>";
        }
    }

}
