<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\admin;

use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Validator;
use App\Country;
use App\Currencyrate;
use Illuminate\Support\Facades\Input;

class CountryFlagController extends Controller {

    public function index() {
        //$searchTerm = Input::get('search', '');
        //$country = Country::SearchByKeyword($searchTerm)->paginate(20);
        //return view('countryflag.index', compact('country','searchTerm'));

        $code = DB::select('select distinct currency_code from country');
        return view('countryflag.index', compact('code', 'code'));
    }

    public function uploadFlagImage() {

        $currency_code = Input::get('currency_code');
        $image = Input::file('image');
        $date = date("Y-m-d H:i:s");
        $rand = strtotime($date);


        $destinationPath = storage_path() . '/uploads/flag_images';


        if ($image->move($destinationPath, $rand . '_' . $currency_code . '_' . $image->getClientOriginalName())) {
            $update = DB::table('country')->where('currency_code', $currency_code)->update(['flag_img' => $rand . '_' . $currency_code . '_' . $image->getClientOriginalName()]);
            Session::flash('flagsave_message', 'Flag Successfully Saved!');
        } else {
            Session::flash('flagsave_message', 'Error While Saving Flag!');
        }

        return redirect('admin/country');
    }

}
