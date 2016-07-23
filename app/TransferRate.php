<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferRate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transferrate';

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
    protected $fillable = ['country_id', 'currency_code','from','to','rate'];
}
