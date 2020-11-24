<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ResellerRequest;
use App\User;
use App\Http\Requests\LoginRequest;
use Auth;
use Session;

class UserController extends Controller
{
    public function register(ResellerRequest $request)
    {
        // 
    }

    public function terms_and_condition()
    {
        return view('terms_and_conditions');
    }

    public function login(LoginRequest $request)
    {
        $email = User::where('email', $request->email)->first();
        $number = User::where('number', $request->number)->first();
        if ($email AND !$number) {
            if (Auth::attempt(['email' => $request->email,'password' => $request->password])) {
                // Authentication passed...
                return redirect()->intended('home');
            } else {
                Session::flash('wrong_details', 'Credentials Incorrect!');
                return redirect()->back();
            }
        } else {
            if (Auth::attempt(['number' => $request->email,'password' => $request->password])) {
                // Authentication passed...
                return redirect()->intended('home');
            } else {
                Session::flash('wrong_details', 'Credentials Incorrect!');
                return redirect()->back();
            }
        }
    }
}
