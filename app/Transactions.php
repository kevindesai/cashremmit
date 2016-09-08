<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    protected $fillable = ['switch_transaction_id', 'switch_response', 'switch_status', 'discount', 'adminfee', 'recipient_id', 'user_id', 'amount', 'response', 'status', 'currency_code', 'transaction_by', 'transactionid', 'token'];
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

    public function switchTransfer() {
//        print_r($this->receptient);
        ini_set('soap.wsdl_cache_enabled', 0);
        ini_set('soap.wsdl_cache_ttl', 900);
        ini_set('default_socket_timeout', 15);

        $terminalId = '20000000054';
        $pin = '0012';
        $input_xml = '
                <?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                <FundGate>
                    <direction>request</direction>
                    <action>FT</action>
                    <terminalId>' . $terminalId . '</terminalId>
                    <transaction>
                        <pin>' . $this->encPin($pin) . '</pin>
                        <bankCode>' . $this->receptient->bank_code . '</bankCode>
                        <amount>' . $this->amount . '</amount>
                        <destination>' . $this->receptient->account_number . '</destination>
                        <reference>' . sprintf('%020d', $this->id) . '</reference>
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
            //$data = $soap->process(array("FundRequest"=>$input_xml));
        } catch (Exception $e) {
            die($e->getMessage());
        }
//        print_r($data);
        if ($data->totalSuccess == '1') {
            $this->switch_transaction_id = 'trxid';
            $this->switch_status = 'success';
        } else {
            $this->switch_status = 'failed';
        }
        $this->switch_response = json_encode($data);
        $this->save();
        if($data->totalSuccess){
            return true;
        }else{
            return false;
        }
    }

    public function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    public function encPin($pin) {
        $master_key = substr('KEd4gDNSDdMBxCGliZaC8w==', 0, 16);
        $pin = $this->pkcs5_pad($pin, 16);
        $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($cipher, $master_key, $master_key);
        $encrypted = mcrypt_generic($cipher, $pin);
        return base64_encode($encrypted);
    }

}
