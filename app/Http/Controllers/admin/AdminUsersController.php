<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AdminUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Validator;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index() {

        $users = AdminUser::paginate(15);
        return view('adminusers.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {
        return view('adminusers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request) {
//        echo $request->first_name;die;
        $input = $request->all();
        $validation = Validator::make(
                        $input, array(
                    'name' => array('required', 'alpha_dash'),
                    'email' => array('required', 'email', 'unique:adminuser'),
                    'password' => array('required'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/adminusers/create')
                            ->withErrors($validation)
                            ->withInput();
        }
        $input['password'] = Hash::make($input['password']);
        $input['is_active'] = 1;
        $input['user_type'] = "sub";

        AdminUser::create($input);

        Session::flash('flash_message', 'User added!');

        return redirect('admin/adminusers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id) {
        $user = AdminUser::findOrFail($id);

        return view('adminusers.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id) {
        $user = AdminUser::findOrFail($id);

        return view('adminusers.edit', compact('user'));
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
                    'name' => array('required'),
                    'email' => array('required', 'email'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/adminusers/' . $id . '/edit')
                            ->withErrors($validation)
                            ->withInput();
        }
        $user = AdminUser::findOrFail($id);

        $user->update($request->all());

        Session::flash('flash_message', 'User updated!');

        return redirect('admin/adminusers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id) {
        AdminUser::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect('admin/adminusers');
    }

}
