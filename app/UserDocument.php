<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class UserDocument extends Model 
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_documents';

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
    protected $fillable = ['user_id','doc_type','attributes'];
    
}
