<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipientMaster extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'RecipientMaster';

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
    protected $fillable = ['user_id','first_name','last_name','city_name',
        'mobile_no','country_name','bank_name','account_number','bank_code',
        'middle_name','address_1','address_2','suburb','phone_no','email','region','branch_state','branch',
        'branch_code','attributes'
        ];
}
