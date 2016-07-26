<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TransferRate;
use App\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class TransferRateController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index() {
        $searchTerm = Input::get('search', '');
        $transferrate = TransferRate::SearchByKeyword($searchTerm)->paginate(16);
        return view('transferrate.index', compact('transferrate','searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {
        $country = Country::select(
                        DB::raw("CONCAT(country_name ,'(', currency_code,')') AS country_name, id")
                )->lists('country_name', 'id');

//                Country::lists("CONCAT(country_name , ' ',currency_code )  country_name", 'id');
        $transferrates = [];
        return view('transferrate.create', compact('country', 'transferrates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request) {
        $input = $request->all();
        $insData = [];
        $country = Country::find($input['country_id']);
        foreach ($input['from'] as $k => $v) {
            if ($input['from'][$k] != '' && $input['to'][$k] != '' && $input['rate'][$k] != '') {
                $temp['from'] = $input['from'][$k];
                $temp['to'] = $input['to'][$k];
                $temp['rate'] = $input['rate'][$k];
                $temp['country_id'] = $country->id;
                $temp['currency_code'] = $country->currency_code;
                $insData[] = $temp;
            }
        }
        $transferrates = DB::table('transferrate')->where(['country_id' => $country->id])->delete();
        DB::table('transferrate')->insert($insData);
        return redirect('admin/transferrate');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id) {
        $country = Country::find($id);
        $transferrates = TransferRate::where(['country_id' => $id])->get();
        return view('transferrate.edit', compact('country', 'transferrates', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request) {
        $input = $request->all();
        $insData = [];
        foreach ($input['from'] as $k => $v) {
            if ($input['from'][$k] != '' && $input['to'][$k] != '' && $input['rate'][$k] != '') {
                $temp['from'] = $input['from'][$k];
                $temp['to'] = $input['to'][$k];
                $temp['rate'] = $input['rate'][$k];
                $temp['country_id'] = $id;
                $temp['currency_code'] = $input['currency_code'];
                $insData[] = $temp;
            }
        }
        $transferrates = DB::table('transferrate')->where(['country_id' => $id])->delete();
        DB::table('transferrate')->insert($insData);

        Session::flash('flash_message', 'Rate updated!');

        return redirect('admin/transferrate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id) {
        
    }

}
