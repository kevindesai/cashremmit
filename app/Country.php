<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'country';

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
    protected $fillable = ['country_name', 'country_code', 'currency_name', 'currency_code'];
    protected $appends = array('logo16', 'logo24', 'logo32', 'logo48', 'logo128');

    public function getLogo16Attribute() {
        if ($this->flag_img) {
            return URL('/storage/uploads/flag_images/') . "/" . $this->flag_img;
        } else {
            return '';
        }
    }

    public function getLogo24Attribute() {
        if ($this->flag_img) {
            return URL('/storage/uploads/flag_images/') . "/" . $this->flag_img;
        } else {
            return '';
        }
    }

    public function getLogo128Attribute() {
        if ($this->flag_img) {
            return URL('/storage/uploads/flag_images/') . "/" . $this->flag_img;
        } else {
            return '';
        }
    }

    public function getLogo32Attribute() {
        if ($this->flag_img) {
            return URL('/storage/uploads/flag_images/') . "/" . $this->flag_img;
        } else {
            return '';
        }
    }

    public function getLogo48Attribute() {
        if ($this->flag_img) {
            return URL('/storage/uploads/flag_images/') . "/" . $this->flag_img;
        } else {
            return '';
        }
    }

    public static function csv_to_array($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return FALSE;

        $header = ['country_name', 'country_code', 'currency_name', 'currency_code'];
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }

    public function scopeSearchByKeyword($query, $keyword) {
        if ($keyword != '') {
            $query->where(function ($query) use ($keyword) {
                $query->where("country_name", "LIKE", "%$keyword%")
                        ->orWhere("country_code", "LIKE", "%$keyword%")
                        ->orWhere("currency_name", "LIKE", "%$keyword%")
                        ->orWhere("currency_code", "LIKE", "%$keyword%");
            });
        }
        return $query;
    }

}
