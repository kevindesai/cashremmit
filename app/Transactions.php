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
    protected $fillable = ['recipient_id','user_id','amount','response','status','currency_code'];
    public function user() {
        return $this->belongsTo('App\User','user_id');
    }
    public function receptient() {
        return $this->belongsTo('App\RecipientMaster','recipient_id');
    }	
}
