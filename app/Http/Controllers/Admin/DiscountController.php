<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiscountCode;
use DB;
use App\Product;
use App\User;

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
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search_product(Request $request)
    {
        $product_title = $request->product_title;
        $output = '<ul id="List">';
        if ($product_title) {
            $products = Product::where('post_title', 'like', "%$product_title%")->where('post_type', 'product')->get();
            foreach($products as $product) {
                $output .= '<li>
                                <a href="javascript:void(0)">
                                    <span>Product ID: '.$product->ID.'</span><br />
                                    <span>Product Title: '.$product->post_title.'</span>
                                </a>
                            </li>';
            }
        } else {
            $output .= '<li>Product Not Found!</li>';
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
                                <a href="javascript:void(0)">
                                    <span>Name: '.$user->name.'</span>
                                    <span>Email: '.$user->email.'</span>
                                </a>
                            </li>';
            }
        } else {
            $output .= '<li>User Not Found</li>';
        }
        $output .= '</ul>';
        $data = array('final' => $output);

        return json_encode($data);
    }
}
