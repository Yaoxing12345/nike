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
use Session;
use Log;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    protected $logFormat = 'className -->'.__CLASS__ .' Line No '.__LINE__;

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
        Log::info($this->logFormat.' user sgetCurrencyConverterListubmited a request for creating a new user for email '.$input['email']);
        $valid = Validator::make($input, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed',
        ]);

        if($valid->fails()){
            Log::info($this->logFormat.' Validation got failed for '.$input['email'].' reason'.json_encode($valid->errors()));
            return view('auth.register')->withErrors($valid)->withInput(Input::except('password'));
        }

        try{
            $res =  User::create([
                        'name'=>$input['name'],
                        'email' => $input['email'],
                        'password' => bcrypt($input['password']),
                    ]);
            Log::info($this->logFormat.' New user got succelly created for email '.$input['email']);
            Session::flash('message', 'Successfully got Registered ..!!..Please Log In');
            Session::flash('alert-class', 'alert-success'); 
            return Redirect::to('/login');        
        }catch(\Exception $e){
            Log::info($this->logFormat.' Exception ocuured while creating user record for email '.$input['email'].' reason'.print_r($e->getMessage(),true));
            return view('auth.register')->withErrors('Oops Something went wrong');
        }
        
    }

    public function checkLogin(Request $request){
        $input = $request->only(['email', 'password','remember']);
        Log::info($this->logFormat.' user trying to loing for email '.$input['email']);
        $valid = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if($valid->fails()){
            Log::info($this->logFormat.' Validation got failed for '.$input['email'].' reason'.json_encode($valid->errors()));
           return view('auth.login')->withErrors($valid)->withInput(Input::except('password'));
        }
    
        $remember = 0;
        if(isset($input['remember']) && !empty($remember))
            $remember = 1;
        
        $res = Auth::attempt(['email' => $input['email'], 'password' => $input['password']], $remember);
        if ($res) {
            Log::info($this->logFormat.' user got succelly logged for email '.$input['email']);
            return redirect('currency-converter');
        }else{
            Log::info($this->logFormat.' some problem occured while logging for email '.$input['email']);
            Session::flash('message', 'The email/password combination is not valid ..!');
            Session::flash('alert-class', 'alert-danger'); 
            return redirect('/login');
        }
    }

    public function logout(){
         Auth::logout();
         return redirect('login');
    }
}
