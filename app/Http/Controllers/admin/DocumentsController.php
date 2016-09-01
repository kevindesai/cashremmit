<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Documents;
use App\Country;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Validator;

class DocumentsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index() {
        $documents = Documents::paginate(15);

        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {
        $country = Country::lists('country_name', 'id');
        return view('documents.create', compact('country'));
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
                    'name' => array('required', 'unique:documents,name,null,id,country_id,'.$inputs['country_id']),
                    'country_id' => array('required'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/documents/create')
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

        Documents::create($inputs);

        Session::flash('flash_message', 'Document added!');

        return redirect('admin/documents');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id) {
        $documents = Documents::findOrFail($id);

        return view('documents.show', compact('documents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id) {

        $documents = Documents::findOrFail($id);
        $country = Country::lists('country_name', 'id');
        return view('documents.edit', compact('documents', 'country'));
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
                    'name' => array('required', 'unique:documents,name,'.$id.',id,country_id,'.$inputs['country_id']),
                    'country_id' => array('required'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/documents/' . $id . '/edit')
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
        $documents = Documents::findOrFail($id);
        $documents->update($inputs);

        Session::flash('flash_message', 'Document updated!');

        return redirect('admin/documents');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id) {
        Documents::destroy($id);

        Session::flash('flash_message', 'Document deleted!');

        return redirect('admin/documents');
    }

}
