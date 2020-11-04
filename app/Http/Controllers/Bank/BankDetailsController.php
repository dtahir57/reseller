<?php

namespace App\Http\Controllers\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankDetail;
use Auth;
use Session;
use App\Http\Requests\BankDetailRequest;

class BankDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank = BankDetail::where('user_id', Auth::user()->id)->first();
        return view('bank_detail.index', compact('bank'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bank_detail.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankDetailRequest $request)
    {
        $bank = new BankDetail;
        $bank->user_id = Auth::user()->id;
        $bank->account_title = $request->account_title;
        $bank->account_number = $request->account_number;
        $bank->bank_name = $request->bank_name;
        $bank->phone_number = $request->phone_number;
        $bank->email = $request->email;
        $bank->save();
        Session::flash('created', 'Bank Details Added Successfully!');
        return redirect()->route('bank_detail.index');
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
        $bank = BankDetail::find($id);
        return view('bank_detail.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BankDetailRequest $request, $id)
    {
        $bank = BankDetail::find($id);
        $bank->account_title = $request->account_title;
        $bank->account_number = $request->account_number;
        $bank->bank_name = $request->bank_name;
        $bank->phone_number = $request->phone_number;
        $bank->email = $request->email;
        $bank->update();
        Session::flash('updated', 'Bank Details Updated Successfully!');
        return redirect()->route('bank_detail.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = BankDetail::find($id);
        $bank->delete();
        Session::flash('deleted', 'Bank Details Deleted Successfully!');
        return redirect()->route('bank_detail.index');
    }
}
