<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\AdminUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Validator;
use Illuminate\Support\Facades\Hash;
class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index() {

        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create() {
        return view('users.create');
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
                    'first_name' => array('required', 'alpha_dash'),
                    'last_name' => array('required', 'alpha_dash'),
                    'email' => array('required', 'email'),
                    'city' => array('required'),
                    'post_code' => array('required'),
                    'country' => array('required'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/users/create')
                            ->withErrors($validation)
                            ->withInput();
        }

        User::create($request->all());

        Session::flash('flash_message', 'User added!');

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id) {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id) {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
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
                    'first_name' => array('required', 'alpha_dash'),
                    'last_name' => array('required', 'alpha_dash'),
                    'email' => array('required', 'email'),
                    'city' => array('required'),
                    'post_code' => array('required'),
                    'country' => array('required'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/users/' . $id . '/edit')
                            ->withErrors($validation)
                            ->withInput();
        }
        $user = User::findOrFail($id);

        $user->update($request->all());

        Session::flash('flash_message', 'User updated!');

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id) {
        User::destroy($id);

        Session::flash('flash_message', 'User deleted!');

        return redirect('admin/users');
    }

    public function Profile() {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('users.profile', compact('user'));
    }
    public function ProfileEdit() {
        $user = AdminUser::findOrFail(\Illuminate\Support\Facades\Auth::user()->id);
        return view('users.profileEdit', compact('user'));
    }
    public function ProfileUpdate(Request $request) {
        $validation = Validator::make(
                        $request->all(), array(
                    'name' => array('required', 'alpha_dash'),
                    'email' => array('required', 'email'),
                        )
        );
        if ($validation->fails()) {
            return redirect('admin/profile/edit')
                            ->withErrors($validation)
                            ->withInput();
        }
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $users = AdminUser::findOrFail($user->id);

        $users->update($request->all());
        return redirect('admin/profile');
    }
    public function Password() {
        return view('users.password');
    }
    public function ChangePassword(Request $request) {
        $input = $request->all();
        $validation = Validator::make(
                        $input, array(
                     'password' => array('required','confirmed'),
//                     'confirmed' => array('required','confirmed')
                        )
        );
        
//        if ($validation->fails()) {
//            return redirect('admin/password')
//                            ->withErrors($validation)
//                            ->withInput();
//        }
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $users = AdminUser::findOrFail($user->id);
        $data['password'] = Hash::make($input['password']);
                
        $users->update($data);
        return redirect('admin/password');
    }
}
