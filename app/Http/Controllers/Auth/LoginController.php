<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\User;
use App\Mail\RegisterUser;
use App\Mail\RegisterAdmin;
use Illuminate\Support\Facades\Mail;
use Socialite;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function fbRedirect()
    {
        return Socialite::driver('facebook')->redirect();   
    }   

    public function fbCallback()
    {
        $providerUser = Socialite::driver('facebook')->user();
        
        $fbEmail = $providerUser->getEmail();
        $fbUser = User::where('email', $fbEmail)->first();
        
        if(!$fbUser) {
            
            $fbID       = $providerUser->getId();
            $fbName     = $providerUser->getName();
            $fbAvatar   = $providerUser->getAvatar();
            
            $newUser = User::create([
                'name'      => $fbName,
                'email'     => $fbEmail,
                'password'  => bcrypt(str_random(12)),
                'fbid'      => $fbID,
                'avatar'    => $fbAvatar
            ]);
            
            Mail::to('register@bookndapp.com')->send(new RegisterAdmin($newUser));
            Mail::to($newUser->email)->send(new RegisterUser($newUser));
            
            Auth::loginUsingId($newUser->id,false);
            return redirect('dashboard');
            
        } else {
            
            Auth::loginUsingId($fbUser->id,false);
            return redirect('dashboard');
            
        }
    }
}
