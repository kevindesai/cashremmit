<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Bank;
use App\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Validator;

class BanksController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index() {
        $banks = Bank::paginate(15);

        return view('banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {
        $country = Country::lists('country_name', 'id');
        return view('banks.create', compact('country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request) {
        $inputs = $request->all();
        $validation = Validator::make(
                        $inputs, array(
                    'name' => array('required', 'unique:banks,name,null,id,country_id,'.$inputs['country_id']),
                    'country_id' => array('required'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/banks/create')
                            ->withErrors($validation)
                            ->withInput();
        }
        $attr = array();
        if (isset($inputs['attr']) && isset($inputs['validation']) && !empty($inputs['attr'])) {
            foreach ($inputs['attr'] as $k => $at) {
                if ($at != "" && isset($inputs['validation'][$k]) && $inputs['validation'][$k] != "") {
                    $attr[] = [
                        'name' => $at,
                        'validation' => $inputs['validation'][$k]
                    ];
                }
            }
        }
        $inputs['attributes'] = json_encode($attr);

        Bank::create($inputs);

        Session::flash('flash_message', 'Bank added!');

        return redirect('admin/banks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id) {
        $bank = Bank::findOrFail($id);

        return view('banks.show', compact('bank'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id) {

        $bank = Bank::findOrFail($id);
        $country = Country::lists('country_name', 'id');
        return view('banks.edit', compact('bank', 'country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request) {
        $inputs = $request->all();
        $validation = Validator::make(
                        $inputs, array(
                    'name' => array('required', 'unique:banks,name,'.$id.',id,country_id,'.$inputs['country_id']),
                    'country_id' => array('required'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/banks/' . $id . '/edit')
                            ->withErrors($validation)
                            ->withInput();
        }
        $attr = array();
        if (isset($inputs['attr']) && isset($inputs['validation']) && !empty($inputs['attr'])) {
            foreach ($inputs['attr'] as $k => $at) {
                if ($at != "" && isset($inputs['validation'][$k]) && $inputs['validation'][$k] != "") {
                    $attr[] = [
                        'name' => $at,
                        'validation' => $inputs['validation'][$k]
                    ];
                }
            }
        }
        $inputs['attributes'] = json_encode($attr);
        $bank = Bank::findOrFail($id);
        $bank->update($inputs);

        Session::flash('flash_message', 'Bank updated!');

        return redirect('admin/banks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id) {
        Bank::destroy($id);

        Session::flash('flash_message', 'Bank deleted!');

        return redirect('admin/banks');
    }

}
