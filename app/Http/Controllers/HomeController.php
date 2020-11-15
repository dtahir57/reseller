<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->hasRole('Super_User')) {
            $processing_orders = Order::where('status', 'processing')->get();
            $delivered_orders = Order::where('status', 'delivered')->get();
            $returned_orders = Order::where('status', 'returned')->get();
        } else {
            $processing_orders = Order::where('user_id', Auth::user()->id)->where('status', 'processing')->get();
            $delivered_orders = Order::where('user_id', Auth::user()->id)->where('status', 'delivered')->get();
            $returned_orders = Order::where('user_id', Auth::user()->id)->where('status', 'returned')->get();
        }
        return view('home', compact('processing_orders', 'delivered_orders', 'returned_orders'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
