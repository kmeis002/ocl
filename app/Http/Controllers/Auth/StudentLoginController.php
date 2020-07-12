<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;

class StudentLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/student';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        return view('auth.studentLogin');

    }

    //override AuthenticatedUsers method
    public function login(Request $request){

        $this->validate($request, [
            'name' => ['required', 'string'],
            'password' => ['required', 'string']
        ]);


        //login attempts
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = [
            'name' => $request->name,
            'password' => $request->password
        ];
        
        //attempt to log user in as student
        if(Auth::guard('student')->attempt($credentials, $request->remember)){
            return $this->sendLoginResponse($request);
        }
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }



}
