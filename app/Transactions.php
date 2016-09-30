<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Flutterwave\Disbursement;
use Flutterwave\Flutterwave;
use Flutterwave\Countries;
use Flutterwave\Currencies;
use Mail;
use Aloha\Twilio\Facades\Twilio as Twilio;

class Transactions extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['to_cur_code','transfer_amount', 'switch_transaction_id', 'switch_response', 'switch_status', 'discount', 'adminfee', 'recipient_id', 'user_id', 'amount', 'response', 'status', 'currency_code', 'transaction_by', 'transactionid', 'token'];
    protected $appends = array('receipentname', 'username');

    public function getReceipentnameAttribute() {
        return $this->receptient->first_name . " " . $this->receptient->last_name;
    }

    public function getUsernameAttribute() {
        return $this->user->first_name . " " . $this->user->last_name;
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function receptient() {
        return $this->belongsTo('App\RecipientMaster', 'recipient_id');
    }

    public static function getTransactionDetail($token) {
        $auth = base64_encode('S6102571:4H1M9GCJ');
        $header = array();
        $header[] = 'Content-Type: application/json';
        $header[] = 'Authorization: Basic ' . $auth;
        $url = "https://poliapi.apac.paywithpoli.com/api/Transaction/GetTransaction?token=" . urlencode($token);

        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Authorization: Basic " . $auth
            )
        );
        try {
            $context = stream_context_create($opts);
            $response = file_get_contents($url, false, $context);
        } catch (Exception $e) {
            $response = array();
        }

        return json_decode($response);
    }

    public function currencyConvert($from, $to, $amount) {
        $data = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from&to=$to");
        preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
        if (isset($converted[1]))
            return $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        else
            return preg_replace("/[^0-9.]/", "", $amount);
    }

    public function switchTransfer() {
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
        $amount = preg_replace("/[^0-9.]/", "", $this->transfer_amount);

        $uniqueRef = sprintf('%05d', $this->id) . "-" . time() . "-" . rand(1000, 99999); //This reference has to be unique
        $senderName = "Godswill Okwara";
        $destination = [
            "country" => Countries::NIGERIA,
            "currency" => Currencies::NAIRA,
            "bankCode" => "044", //the 044 represents the bank code, you can get all bank codes using the bank API
            "recipientAccount" => $this->receptient->account_number, //Make sure you havent added this account before
            "recipientName" => $this->receipentname
        ];
        $narration = "TR/" . $this->transfer_amount . "/TO/" . $this->receipentname;
        $result4 = Disbursement::send($accountToken, $uniqueRef, $amount, $narration, $senderName, $destination);
        $response4 = $result4->getResponseData();

        if ($result4->isSuccessfulResponse()) {
//          $this->switch_transaction_id = 'trxid';
            $this->switch_status = 'success';
            $tNo = sprintf('%010d', $this->id);
            $getUserDetail = $this->user;
            $UserMob = $getUserDetail->mobile_no;
            $UserName = $getUserDetail->first_name . ' ' . $getUserDetail->last_name;

            $getRecipentDetail = $this->receptient;
            $RecipentMob = $getRecipentDetail->mobile_no;
            $RecipentName = $getRecipentDetail->first_name . ' ' . $getRecipentDetail->last_name;


//            $UserMsg = $RecipentName . " have received " . $this->transfer_amount . " NGN from you ";
            $UserMsg = "Your Money Transfer of NGN " . $this->transfer_amount . " reference No: ".$tNo." to Nigeria is completed Now, Thank you for using CashRemit.";

            $RecipentMsg = "Your account has been creadited NGN " . $this->transfer_amount . " by " . $UserName . " via CashRemit.TXT NO : ".$tNo.".";
            $toemail = $getRecipentDetail->email;
            $data = array(
                'name' => $this->username,
                'rec_name' => $this->receipentname,
                'currency' => 'NGN',
                'amount' => $this->transfer_amount,
                'msg'=>$RecipentMsg,
                "toemail" => $toemail
            );

            try {
                if ($toemail != '' || $toemail != null) {
                    Mail::send('emails.successPayment', array("data" => $data), function ($message) use ($data) {

                        $message->from('support@cashremit.com.au', 'Cash Remit');

                        $message->to($data["toemail"])->subject('Cashremit Transfer successfull');
                    });
                }

                if($UserMob)
                 Twilio::message('+' . $UserMob, $UserMsg);
                if($RecipentMob)
                 Twilio::message('+' . $RecipentMob, $RecipentMsg);
            } catch (Exception $e) {
                
            }
            /* $getRecipentDetail = \App\RecipientMaster::find($trensaction->recipient_id);
              $RecipentMob = $getRecipentDetail->mobile_no; */
        } else {
            $this->switch_status = 'failed';
        }
        $this->switch_transaction_id = $uniqueRef;
        $this->switch_response = json_encode($response4);
        $this->save();
        if ($result4->isSuccessfulResponse()) {
            return [
                'status' => 1,
                'data' => $response4
            ];
        } else {
            return [
                'status' => 0,
                'data' => $response4
            ];
        }
    }

}
