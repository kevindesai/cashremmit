<?php 

namespace App\Http\Controllers\Auth;
 
use App\AdminUser;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
 
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller {
 
    /**
     * the model instance
     * @var User
     */
    protected $user; 
    /**
     * The Guard implementation.
     *
     * @var Authenticator
     */
    protected $auth;
 
    /**
     * Create a new authentication controller instance.
     *
     * @param  Authenticator  $auth
     * @return void
     */
    public function __construct(Guard $auth, AdminUser $user)
    {
        $this->user = $user; 
        $this->auth = $auth;
 
        $this->middleware('guest', ['except' => ['getLogout']]); 
    }
     /**
     * Show the application login form.
     *
     * @return Response
     */
    public function showLogin()
    {
        return view('login');
    }
 
    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
     */
    public function doLogin(LoginRequest $request)
    {
        $userData =  $request->only('email', 'password');
        $userData['password']=  base64_encode($userData['password']);
//        print_r(Auth::validate($request->only('email', 'password')));die;
//        if ($this->auth->attempt($userData,true))
//        {
//            return redirect('/users');
//        }
        
//        print_r($userData['email']);
        $aduser =AdminUser::where(['email'=>$userData['email'],'password'=>  $userData['password']])->first();
        if($aduser){
//            $this->auth->login($aduser);
            return redirect('/users');
        } 
        return redirect('/login')->withErrors([
            'email' => 'The credentials you entered did not match our records. Try again?',
        ]);
    }
 
    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getLogout()
    {
        $this->auth->logout();
 
        return redirect('/');
    }
 
}