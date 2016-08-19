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
    protected $fillable = ['discount', 'adminfee', 'recipient_id', 'user_id', 'amount', 'response', 'status', 'currency_code', 'transaction_by', 'transactionid', 'token'];
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

        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);
        return json_decode($response);
    }

}
