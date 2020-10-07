<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiscountCode;
use DB;
use App\Product;
use App\User;
use App\Http\Requests\DiscountRequest;
use Session;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount_codes = DB::connection('mysql')->table('discount_codes')->orderBy('id', 'DESC')->paginate(10);
        return view('admin.discount.index', compact('discount_codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        $check = DiscountCode::where('product_id', $request->product_id)->where('reseller_id', $request->reseller_id)->first();
        if ($check) {
            Session::flash('error', 'Discount Already given to this Reseller');
            return redirect()->back();
        }
        $discount = new DiscountCode;
        $discount->product_id = $request->product_id;
        $discount->reseller_id = $request->reseller_id;
        $discount->discount = $request->discount;
        $discount->save();
        Session::flash('created', 'New Discount Created Successfully!');
        return redirect()->route('admin.discount.index');
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
        $discount = DiscountCode::find($id);
        $user = User::find($discount->reseller_id);
        $product = Product::where('post_type', 'product')->where('ID', $discount->product_id)->first();
        return view('admin.discount.edit', compact('discount', 'user', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $discount = DiscountCode::find($id);
        $discount->product_id = $request->product_id;
        $discount->reseller_id = $request->reseller_id;
        $discount->discount = $request->discount;
        $discount->update();
        Session::flash('updated', 'Discount Details Updated Successfully!');
        return redirect()->route('admin.discount.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discount = DiscountCode::find($id);
        $discount->delete();
        Session::flash('deleted', 'Discount Deleted Successfully!');
        return redirect()->route('admin.discount.index');
    }

    public function search_product(Request $request)
    {
        $product_title = $request->product_title;
        $output = '<ul id="List">';
        if ($product_title) {
            $products = Product::where('post_title', 'like', "%$product_title%")->where('post_type', 'product')->get();
            foreach($products as $product) {
                $output .= '<li>
                                <a href="javascript:void(0)" onclick="getProduct('.$product->ID.')">
                                    <span>Product ID: '.$product->ID.'</span><br />
                                    <span>Product Title: '.$product->post_title.'</span>
                                </a>
                            </li>';
            }
        } else {
            $output .= '<li style="color:white;">Product Not Found!</li>';
        }
        $output .= '</ul>';
        $data = array('final' => $output);

        return json_encode($data);
    }

    public function search_reseller(Request $request)
    {
        $email = $request->email;
        $output = '<ul id="List">';
        if ($email) {
            $users = User::where('email', 'like', "%$email%")->get();
            foreach($users as $user) {
                $output .= '<li>
                                <a href="javascript:void(0)" onclick="getReseller('.$user->id.')">
                                    <span>Name: '.$user->name.'</span>
                                    <span>Email: '.$user->email.'</span>
                                </a>
                            </li>';
            }
        } else {
            $output .= '<li style="color:white;">User Not Found</li>';
        }
        $output .= '</ul>';
        $data = array('final' => $output);

        return json_encode($data);
    }

    public function get_product(Request $request)
    {
        $product = Product::where('post_type', 'product')->where('ID', $request->id)->first();
        $output = '<div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">Product ID: '.$product->ID.'</div>
                                <div class="col-md-6">Product Title: '.$product->post_title.'</div>
                            </div>
                        </div>
                   </div>
                   <a href="javascript:void(0)" onclick="search_product()">Click here to search product again</a>';
        $data = array('final' => $output);

        return json_encode($data);
    }

    public function get_reseller(Request $request)
    {
        $user = User::find($request->id);
        $output = '<div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">Name: '.$user->name.'</div>
                                <div class="col-md-6">Email: '.$user->email.'</div>
                            </div>
                        </div>
                   </div>
                   <a href="javascript:void(0)" onclick="search_reseller()">Click here to search reseller again</a>';
        $data = array('final' => $output);

        return json_encode($data);
    }
}
