<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\admin;

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

class CountryController extends Controller {

    public function index() {
        $searchTerm = Input::get('search', '');
        $country = Country::SearchByKeyword($searchTerm)->paginate(20);
        return view('country.index', compact('country', 'searchTerm'));
    }

    public function rateList() {
        $rate = Currencyrate::paginate(20);
        $country = Country::lists('currency_code', 'currency_code');
        return view('country.rateList', compact('rate', 'country'));
    }

    public function create() {
        $country = Country::lists('currency_code', 'currency_code');
        return view('country.setRate', compact('country'));
    }

    public function store(Request $request) {
        $inputs = $request->all();
        $validation = Validator::make(
                        $inputs, array(
                    'from' => array('required'),
                    'to' => array('required'),
                    'rate' => array('required'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/country/create')
                            ->withErrors($validation)
                            ->withInput();
        }

        $chk = Currencyrate::where(['to' => $inputs['to'], 'from' => $inputs['from']])->first();
        if (!$chk) {
            Currencyrate::create($request->all());
        } else {
            $chk->update($request->all());
        }
        Session::flash('flash_message', 'Rate Saved!');
        return redirect('admin/rate/list');
    }

    public function edit($id) {
        $currency = Currencyrate::findOrFail($id);
        $country = Country::lists('currency_code', 'currency_code');
        return view('country.editRate', compact('currency', 'country'));
    }

    public function update($id, Request $request) {

        $inputs = $request->all();
        $validation = Validator::make(
                        $inputs, array(
                    'from' => array('required'),
                    'to' => array('required'),
                    'rate' => array('required'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/country/' . $id . '/edit')
                            ->withErrors($validation)
                            ->withInput();
        }

        $chk = Currencyrate::where(['to' => $inputs['to'], 'from' => $inputs['from']])->first();
        if (!$chk) {
            Currencyrate::create($request->all());
        } else {
            $chk->update($request->all());
        }
        Session::flash('flash_message', 'Rate Saved!');
        return redirect('admin/rate/list');
    }

    public function destroy($id) {
        Currencyrate::destroy($id);

        Session::flash('flash_message', 'Rate deleted!');

        return redirect('admin/rate/list');
    }

    public function changeStatus($id, $status) {
        $country = Country::findOrFail($id);
        $response = [
            'status' => 0,
            'message'=>'Some error occures, Try again letter.'
        ];
        if ($country->update(['status' => $status])) {
            $response = [
                'status' => 1,
                'message'=>'Status has been changed.'
            ];
        }
        echo json_encode($response);die;
    }

}
