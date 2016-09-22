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
use Aloha\Twilio\Facades\Twilio as Twilio;

class PoliAPIController extends Api {

    private $_auth;

    public function success($id) {



        $trensaction = \App\Transactions::find($id);
        $trensaction->status = 'success';
        $token = $_REQUEST['token'];
        $getUserDetail = $trensaction->user;
        $UserMob = $getUserDetail->mobile_no;
        $UserName = $getUserDetail->first_name . ' ' . $getUserDetail->last_name;

        $getRecipentDetail = $trensaction->receptient;
        $RecipentMob = $getRecipentDetail->mobile_no;
        $RecipentName = $getRecipentDetail->first_name . ' ' . $getRecipentDetail->last_name;


//        $UserMsg = "You have sent " . $trensaction->amount . " aud to " . $RecipentName . ". It will be credit to your bank account within 2 working days.Please contact support in case of any query.";
        $UserMsg = "You have initiated a transfer of NGN " . $trensaction->transfer_amount . " to " . $RecipentName . ", you will be notified when the payment is been processed. Thank you";

        /* $getRecipentDetail = \App\RecipientMaster::find($trensaction->recipient_id);
          $RecipentMob = $getRecipentDetail->mobile_no; */
        $RecipentMsg = $UserName . " have sent you NGN " . $trensaction->transfer_amount . " via CashRemit. This will be credit to your bank account within 2 working days.";

        $trensaction->response = json_encode(\App\Transactions::getTransactionDetail($token));
        $trensaction->token = $token;
        $trensaction->save();
//        die;
        $toemail = $trensaction->user->email;
        $data = array(
            'name' => $trensaction->username,
            'rec_name' => $trensaction->receipentname,
            'currency' => $trensaction->currency_code,
            'amount' => $trensaction->amount,
            'msg'=>$UserMsg,
            "toemail" => $toemail
        );

        try {
            if ($toemail) {
                Mail::send('emails.successtransfer', array("data" => $data), function ($message) use ($data) {

                    $message->from('support@cashremit.com.au', 'Cash Remit');

                    $message->to($data["toemail"])->subject('Cashremit Transfer successfull');
                });
                
            }
            if ($getRecipentDetail->email) {
                
                $data = array();
                $data = array(
                    'toemail' => $getRecipentDetail->email,
                    'msg' => $RecipentMsg
                );
                
                Mail::send('emails.successtransfer1', array("data" => $data), function ($message) use ($data) {

                    $message->from('support@cashremit.com.au', 'Cash Remit');

                    $message->to($data["toemail"])->subject('Cashremit Transfer initiated');
                });
                
            }
            if ($UserMob)
                Twilio::message('+' . $UserMob, $UserMsg);
            if ($RecipentMob)
                Twilio::message('+' . $RecipentMob, $RecipentMsg);
        } catch (Exception $e) {
            //print_r($e);
        }

        if ($getUserDetail->is_verified == '1') {
            $url = url('/') . '/#/polisuccess/' . base64_encode($token);
            return redirect($url);
        } else {
            $url = url('/') . '/#/successbutnotverified/' . base64_encode($token);
            return redirect($url);
        }
    }

    public function failure($id) {
        $trensaction = \App\Transactions::find($id);
        $trensaction->status = 'failure';
        $trensaction->response = json_encode($this->getTransactionDetail($_REQUEST['token']));
        $trensaction->token = $_REQUEST['token'];
        $trensaction->save();
        $url = url('/') . '/#/polifailure/' . base64_encode($_REQUEST['token']);
        return redirect($url);
    }

    public function cancelled($id) {
        $trensaction = \App\Transactions::find($id);
        $trensaction->status = 'cancelled';
        $trensaction->response = json_encode($this->getTransactionDetail($_REQUEST['token']));
        $trensaction->token = $_REQUEST['token'];
        $trensaction->save();
        $url = url('/') . '/#/policancelled/' . base64_encode($_REQUEST['token']);
        return redirect($url);
    }

    public function nudge($id) {
        $trensaction = \App\Transactions::find($id);
        $trensaction->status = 'nudge';
        $trensaction->response = json_encode($this->getTransactionDetail($_REQUEST['token']));
        $trensaction->token = $_REQUEST['token'];
        $trensaction->save();
        $url = url('/') . '/#/polinudge/' . base64_encode($_REQUEST['token']);
        return redirect($url);
    }

    public function currencyConvert($from, $to, $amount) {
        $data = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from&to=$to");
        preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);

        if (isset($converted[1]))
            $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        else
            $converted = $amount;

        return number_format(round($converted, 3), 2);
    }

    public function initiatetransaction(Request $request) {
        $this->_auth = JWTAuth::toUser(JWTAuth::getToken());

        $baseUrl = url('/');
        $inputs = $request->all();
        $amount = (float) $inputs["amount"] + (float) $inputs["adminfee"] - (float) $inputs["discount"];

        $beginTransaction = array(
            'recipient_id' => $inputs["recipient_id"],
            'user_id' => $this->_auth->id,
            'amount' => (float) $inputs["amount"],
            'adminfee' => (float) $inputs["adminfee"],
            'discount' => (float) $inputs["discount"],
            'status' => 'pending',
            'currency_code' => $inputs["CurrencyCode"],
            'transaction_by' => 'poli',
            'transfer_amount' => $this->currencyConvert($inputs["CurrencyCode"], 'NGN', $inputs["amount"])
        );

        $transaction = \App\Transactions::create($beginTransaction);
        $tr_id = $transaction->id;
//"Amount":"' . $inputs["amount"] + $inputs["adminfee"] - $inputs["discount"] . '",
        $json_builder = '{
                "Amount":"' . $amount . '",                
                "CurrencyCode":"' . $inputs["CurrencyCode"] . '",
                "MerchantReference":"CustomerRef12345",
                "MerchantHomepageURL":"' . $baseUrl . '",
                "SuccessURL":"' . $baseUrl . '/api/v1/poli/success/' . $tr_id . '",
                "FailureURL":"' . $baseUrl . '/api/v1/poli/failure/' . $tr_id . '",
                "CancellationURL":"' . $baseUrl . '/api/v1/poli/cancelled/' . $tr_id . '",
                "NotificationURL":"' . $baseUrl . '/api/v1/poli/nudge/' . $tr_id . '"
              }';

        $publicPath = public_path();
        $auth = base64_encode('S6102571:4H1M9GCJ');
        $header = array();
        $header[] = 'Content-Type: application/json';
        $header[] = 'Authorization: Basic ' . $auth;

        $ch = curl_init("https://poliapi.apac.paywithpoli.com/api/Transaction/Initiate");
        //See the cURL documentation for more information: http://curl.haxx.se/docs/sslcerts.html
        //We recommend using this bundle: https://raw.githubusercontent.com/bagder/ca-bundle/master/ca-bundle.crt
        curl_setopt($ch, CURLOPT_CAINFO, $publicPath . "/ca-bundle.crt");
//        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
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

    public function getTransactionDetail($transactiontoken) {
        $res = \App\Transactions::getTransactionDetail(base64_decode($transactiontoken));
        $response = array(
            'status' => '1',
            'message' => 'data not found',
            'data' => array()
        );
        if ($res) {
            $response = array(
                'status' => '1',
                'message' => 'data found',
                'data' => $res
            );
        }
        echo json_encode($response);
    }

}
