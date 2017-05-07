<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Redirect;
use Input;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function createUser(Request $request)
    {
        $input = $request->all();
        
        $valid = Validator::make($input, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);

        if($valid->fails()){
            return Redirect::to('login')
                ->withErrors($valid) // send back all errors to the login form
                ->withInput(Input::except('password'));
        }

        return User::create([
            'name'=>$input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
        ]);
    }

    public function checkLogin(Request $request){
        $input = $request->only(['email', 'password']);
        $valid = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if($valid->fails()){
            return Redirect::to('login')
                ->withErrors($valid) // send back all errors to the login form
                ->withInput(Input::except('password'));
        }
        $remember = 1;
        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']], $remember)) {
            return redirect('currency-converter');
        }else{
            return redirect('login')->withErrors('invalid credentials')->withInput($request->except(['password']));
        }
    }

    public function logout(){
         Auth::logout();
         return redirect('login');
    }
}
