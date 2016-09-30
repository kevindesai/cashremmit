<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferBonus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'transferbonus';

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
    public function country() {
        return $this->belongsTo('App\Country','country_id');
    }
    public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->whereHas('country',function ($query) use ($keyword) {
                $query->where("country.country_name", "LIKE","%$keyword%")
                    ->orWhere("country.currency_code", "LIKE", "%$keyword%");
            });
        }
        return $query;
    }
}
