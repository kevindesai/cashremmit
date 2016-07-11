<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class User extends Model 
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
    protected $fillable = ['first_name','last_name','unit_no','building_name','city','region','street','post_code','country','dob','mobile_no','landline_no','email','password','remember_token'];
    
    
    public static function getCustomerID($id) {
        return "CR".sprintf("%06d", $id);
    }
    
    public function getRememberToken() {
        return $this->remember_token;
    }

    public function setRememberToken($value) {
        $this->remember_token = $value;
    }

    public function getRememberTokenName() {
        return 'remember_token';
    }

    public function getAuthIdentifierName() {
        return $this->getKeyName();
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->password;
    }

}
