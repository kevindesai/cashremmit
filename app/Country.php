<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Country';

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

}
