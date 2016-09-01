<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promossion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'promossions';

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
    protected $fillable = ['code','is_enable','discount'];
}
