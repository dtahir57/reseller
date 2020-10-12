<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ResellerRequest;
use App\User;

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
}
