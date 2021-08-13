<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function redirectTo()
    {   
        $role = Auth::user()->jabatan;
        switch($role){
            case '1':
                return '/home';
            break; 
            default:
            return '/';
        break;
        }
    }
    public function username()
    {
        return 'nrpnpk';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if($this->guard()->validate($this->credentials($request))) {
            if(Auth::attempt(['nrpnpk' => $request->nrpnpk, 'password' => $request->password, 'status' => '1'])) {
                 return redirect()->intended('/home');
            } 
            else if(Auth::attempt(['nrpnpk' => $request->nrpnpk, 'password' => $request->password, 'status' => '3'])) {
                $error = 'Akun Anda Terblokir, Silahkan Hubungi Admin';
                Auth::logout();
                return view('auth.login',compact('error'));
            }     
            else {
                $this->incrementLoginAttempts($request);
                return response()->json([
                    'error' => 'Something Wrong'
                ], 401);
            }
        } 
        else {
            $this->incrementLoginAttempts($request);
            $error = 'NRP / NPK / Password Salah';
            return view('auth.login',compact('error'));
        }
    }
}
