<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Order;
use DB;
use App\User;
use Session;
use App\Http\Requests\UserRequest;

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

    public function processing_orders()
    {
        if (Auth::user()->hasRole('Super_User')) {
            $processing_orders = DB::table('orders')->where('status', 'processing')->paginate(10);
        } else {
            $processing_orders = DB::table('orders')->where('user_id', Auth::user()->id)->where('status', 'processing')->paginate(10);
        }
        return view('orders.processing_orders', compact('processing_orders'));
    }

    public function delivered_orders()
    {
        if (Auth::user()->hasRole('Super_User')) {
            $delivered_orders = DB::table('orders')->where('status', 'delivered')->paginate(10);
        } else {
            $delivered_orders = DB::table('orders')->where('user_id', Auth::user()->id)->where('status', 'delivered')->paginate(10);
        }
        return view('orders.delivered_orders', compact('delivered_orders'));
    }

    public function returned_orders()
    {
        if (Auth::user()->hasRole('Super_User')) {
            $returned_orders = DB::table('orders')->where('status', 'returned')->paginate(10);
        } else {
            $returned_orders = DB::table('orders')->where('user_id', Auth::user()->id)->where('status', 'returned')->paginate(10);
        }
        return view('orders.returned_orders', compact('returned_orders'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function profile()
    {
        return view('profile.index');
    }

    public function update_profile(UserRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->number = $request->number;
        if ($request->profile_image) {
            $user->profile_image = $request->profile_image->store('public/profile');
        }
        $user->update();
        Session::flash('updated', 'Profile Settings Updated Successfully!');
        return redirect()->back();
    }
}
