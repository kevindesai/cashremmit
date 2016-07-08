<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Promossion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Validator;

class PromossionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index() {

        $promossion = Promossion::paginate(15);
        return view('promossion.index', compact('promossion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {
        return view('promossion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request) {
//        echo $request->first_name;die;
        $validation = Validator::make(
                        $request->all(), array(
                    'code' => array('required','unique:promossions'),
                            'discount' => array('required', 'regex:/^\d*(\.\d{2})?$/')
                        )
        );
        if ($validation->fails()) {
            return redirect('promossion/create')
                        ->withErrors($validation)
                        ->withInput();
        }

        Promossion::create($request->all());

        Session::flash('flash_message', 'Promossion added!');

        return redirect('promossion');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
//    public function show($id) {
//        $user = User::findOrFail($id);
//
//        return view('users.show', compact('user'));
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id) {
        $promossion = Promossion::findOrFail($id);

        return view('promossion.edit', compact('promossion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request) {
        
        $validation = Validator::make(
                        $request->all(), array(
                    'code' => array('required','unique:promossions,code,'.$id),
                        )
        );
        $input = $request->all();
        if ($validation->fails()) {
            return redirect('promossion/'.$id.'/edit')
                        ->withErrors($validation)
                        ->withInput();
        }
        if(!isset($input['is_enable'])){
            $input['is_enable'] = 0;
        }
        $promossion = Promossion::findOrFail($id);
        
        $promossion->update($input);

        Session::flash('flash_message', 'Promossion updated!');

        return redirect('promossion');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id) {
        Promossion::destroy($id);

        Session::flash('flash_message', 'Promossion deleted!');

        return redirect('promossion');
    }

}
