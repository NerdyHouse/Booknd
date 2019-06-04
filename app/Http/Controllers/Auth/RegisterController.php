<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Mail\RegisterUser;
use App\Mail\RegisterAdmin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        
        $messages = [
            'required'  => 'This field is required',
            'email'     => 'Please enter a valid email address',
            'min'       => 'The password must be at least 6 characters',
            'confirmed' => 'The passwords entered do not match'
        ];
        
        return Validator::make($data, [
            'rname' => 'required|string|max:255',
            'remail' => 'required|string|email|max:255|unique:users,email',
            'rpassword' => 'required|string|min:6|confirmed',
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $newUser = User::create([
            'name' => $data['rname'],
            'email' => $data['remail'],
            'password' => bcrypt($data['rpassword']),
        ]);
        
        Mail::to('register@bookndapp.com')->send(new RegisterAdmin($newUser));
        Mail::to($newUser->email)->send(new RegisterUser($newUser));
        
        return $newUser;
    }
}
