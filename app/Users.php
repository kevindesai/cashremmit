<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Users';

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
    protected $fillable = ['firsname', 'lastname','email','contact','password'];
}
