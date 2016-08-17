<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
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
    protected $fillable = ['discount','adminfee','recipient_id','user_id','amount','response','status','currency_code','transaction_by','transactionid','token'];
    protected $appends = array('receipentname','username');
    public function getReceipentnameAttribute()
    {
        return $this->receptient->first_name. " ".$this->receptient->last_name;  
    }
    public function getUsernameAttribute()
    {
        return $this->user->first_name. " ".$this->user->last_name;  
    }
    
    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
    public function receptient() {
        return $this->belongsTo('App\RecipientMaster','recipient_id');
    }	
}
