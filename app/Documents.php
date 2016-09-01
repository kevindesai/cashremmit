<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents';

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
    protected $fillable = ['name', 'country_id', 'attributes'];

    public function country() {
        return $this->belongsTo('App\Country');
    }

}
