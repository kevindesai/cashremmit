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
use App\RecipientMaster;
use Session;
use Response;
use Validator;
use Exception;
use JWTAuth;
use Mail;

class PoliAPIController extends Api {

    private $_auth;

    public function getTransactionDetail($token) {

        $auth = base64_encode('S6102571:4H1M9GCJ');
        $header = array();
        $header[] = 'Authorization: Basic ' . $auth;

        $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/GetTransaction?token=" . urlencode($token));
        //See the cURL documentation for more information: http://curl.haxx.se/docs/sslcerts.html
        //We recommend using this bundle: https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
        //curl_setopt( $ch, CURLOPT_CAINFO, "ca-bundle.crt");
        //curl_setopt( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return $json = json_decode($response, true);
    }

    public function success($id) {
        $trensaction = \App\Transactions::find($id);
        $trensaction->status = 'success';
        $token = $_REQUEST['token'];
        $res = array(
            'token'=>$token,
            'data' => $this->getTransactionDetail($token)
        );
//        echo "<pre>";
//        print_r($res);
        $trensaction->response = json_encode($res);
        $trensaction->save();
//        die;
        $toemail = $trensaction->user->email;
        $data = array(
            'name' => $trensaction->username,
            'rec_name' => $trensaction->receipentname,
            'currency' => $trensaction->currency_code,
            'amount' => $trensaction->amount,
            "toemail" => $toemail
        );

        Mail::send('emails.successtransfer', array("data" => $data), function ($message) use ($data) {

            $message->from('ravi@atoatechnologies.com', 'Cash Remit');

            $message->to($data["toemail"])->subject('Cashremit Transfer successfull');
        });

        $url = url('/') . '/#/polisuccess';
        return redirect($url);
    }

    public function failure($id) {
        $trensaction = \App\Transactions::find($id);
        $trensaction->status = 'failure';
        $trensaction->response = $_REQUEST['token'];
        $trensaction->save();
        $url = url('/') . '/#/polifailure';
        return redirect($url);
    }

    public function cancelled($id) {
        $trensaction = \App\Transactions::find($id);
        $trensaction->status = 'cancelled';
        $trensaction->response = $_REQUEST['token'];
        $trensaction->save();
        $url = url('/') . '/#/policancelled';
        return redirect($url);
    }

    public function nudge($id) {
        $trensaction = \App\Transactions::find($id);
        $trensaction->status = 'nudge';
        $trensaction->response = $_REQUEST['token'];
        $trensaction->save();
        $url = url('/') . '/#/polinudge';
        return redirect($url);
    }

    public function initiatetransaction(Request $request) {
        $this->_auth = JWTAuth::toUser(JWTAuth::getToken());

        $baseUrl = url('/');
        $inputs = $request->all();
        $beginTransaction = array(
            'recipient_id' => $inputs["recipient_id"],
            'user_id' => $this->_auth->id,
            'amount' => $inputs["amount"],
            'status' => 'pending',
            'currency_code' => $inputs["CurrencyCode"]
        );

        $transaction = \App\Transactions::create($beginTransaction);
        $tr_id = $transaction->id;

        $json_builder = '{
                "Amount":"' . $inputs["amount"] . '",
                "CurrencyCode":"' . $inputs["CurrencyCode"] . '",
                "MerchantReference":"CustomerRef12345",
                "MerchantHomepageURL":"' . $baseUrl . '",
                "SuccessURL":"' . $baseUrl . '/api/v1/poli/success/' . $tr_id . '",
                "FailureURL":"' . $baseUrl . '/api/v1/poli/failure/' . $tr_id . '",
                "CancellationURL":"' . $baseUrl . '/api/v1/poli/cancelled/' . $tr_id . '",
                "NotificationURL":"' . $baseUrl . '/api/v1/poli/nudge/' . $tr_id . '" 
              }';
//        $json_builder = '{
//                "Amount":"' . $inputs["amount"] . '",
//                "CurrencyCode":"' . $inputs["CurrencyCode"] . '",
//                "MerchantReference":"CustomerRef12345",
//                "MerchantHomepageURL":"' . $baseUrl . '",
//                "SuccessURL":"' . $baseUrl . '/#/polisuccess",
//                "FailureURL":"' . $baseUrl . '/#/polifailure",
//                "CancellationURL":"' . $baseUrl . '/#/policancelled",
//                "NotificationURL":"' . $baseUrl . '/#/polinudge" 
//              }';

        $publicPath = public_path();
        $auth = base64_encode('S6102571:4H1M9GCJ');
        $header = array();
        $header[] = 'Content-Type: application/json';
        $header[] = 'Authorization: Basic ' . $auth;

        $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/Initiate");
        //See the cURL documentation for more information: http://curl.haxx.se/docs/sslcerts.html
        //We recommend using this bundle: https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
        curl_setopt($ch, CURLOPT_CAINFO, $publicPath . "/ca-bundle.crt");
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_builder);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
        } else {
            //$resArr = json_decode($response);
            //header('Location: '.$resArr->NavigateURL	);
            echo $response;
        }
        curl_close($ch);
    }

    public function getTransactions() {
        $this->_auth = JWTAuth::toUser(JWTAuth::getToken());
        $transactions = \App\Transactions::where('user_id', $this->_auth->id)->orderBy('id', 'desc')->get();
        $response = array(
            'status' => '0',
            'message' => 'No data found'
        );
        $transactions = $transactions->toArray();
        if (!empty($transactions)) {
            $response = array(
                'status' => '1',
                'message' => 'data found',
                'data' => $transactions
            );
        }
        echo json_encode($response);
    }

}
