<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\ResellerRequest;
use Session;

class ResellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereHas("roles", function($q){ 
            $q->where("name", "Reseller"); 
        })->get();
        return view('admin.resellers.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.resellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResellerRequest $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->number = $request->number;
        $user->city = $request->city;
        $user->password = bcrypt($request->password);
        $user->save();
        $user->assignRole('Reseller');
        Session::flash('created', 'New Reseller Created Successfully!');
        return redirect()->route('admin.reseller.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reseller = User::find($id);
        return view('admin.resellers.edit', compact('reseller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResellerRequest $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->discount = $request->discount;
        $user->update();
        Session::flash('updated', 'Reseller Details Updated Successfully!');
        return redirect()->route('admin.reseller.index');
    }

    public function create_discount()
    {
        return view('admin.resellers.discount');
    }

    public function reseller_discount(Request $request)
    {
        $users = User::role('Reseller')->get();
        foreach($users as $user) {
            $user->discount = $request->discount;
            $user->update();
        }
        Session::flash('discount_added', 'Discount Added To All Resellers');
        return redirect()->route('admin.reseller.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        Session::flash('deleted', 'User Deleted Successfully!');
        return redirect()->route('admin.reseller.index');
    }

    public function weekly_deduction()
    {
        $users = User::role('Reseller')->get();
        foreach($users as $user) {
            $user->balance = $user->balance - 250;
            $user->update();
        }
    }

    public function approve($reseller_id)
    {
        $user = User::find($reseller_id);
        $user->status = 'approved';
        $user->update();
        Session::flash('approved', 'Reseller Approved Successfully!');
        return redirect()->route('admin.reseller.index');
    }

    public function disapprove($reseller_id)
    {
        $user = User::find($reseller_id);
        $user->status = 'pending';
        $user->update();
        Session::flash('disapproved', 'Reseller Disapproved Successfully!');
        return redirect()->route('admin.reseller.index');
    }
}
