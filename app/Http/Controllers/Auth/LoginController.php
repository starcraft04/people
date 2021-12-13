<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
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

    //API login

    public function loginApi(Request $request)
    {
        $request->validate([
            'email'=>['required','email'],
            'password'=>['required']
        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages([
                'email' => ['this is worng']
            ]);
        }

        $userToken = array(
            'token'=>$user->createToken('Auth Token')->accessToken
        );

        return json_encode($userToken);
    }
}
