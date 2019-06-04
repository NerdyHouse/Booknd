<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function __construct()
    {
    }
    
    public function index()
    {
        return view('contact');
    }
    
    public function submit(Request $request) {
        
        $messages = [
            'required'  => 'This field is required.',
            'email'     => 'Please enter a valid email address'
        ];
        
        $this->validate($request,[
            'cname'     => 'required',
            'cemail'    => 'required|email',
            'cmessage'  => 'required'
        ],$messages);
        
        Mail::to('register@bookndapp.com')
                ->send(new ContactForm($request->cname,$request->cemail,$request->cmessage));
        
        return view('contact',['success' => 'success']);
    }
    
}
