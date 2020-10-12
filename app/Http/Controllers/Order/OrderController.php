<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WordpressModels\Product;
use DB;
use App\Models\Order;
use Auth;
use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = DB::connection('mysql2')->table('wpjo_posts')->where('post_type', 'shop_order')->paginate(15);
        // $postmeta = DB::connection('mysql2')->table('wpjo_postmeta')->where('post_id', 5040)->get();
        // dd($postmeta);
        // $order = DB::connection('mysql2')->table('wpjo_woocommerce_order_items')->paginate(10);
        // $texanomies = DB::connection('mysql2')->table('wpjo_postmeta')->paginate(20);
        // dd($texanomies);
        // dd($order);
        // dd($products);
        $orders = DB::table('orders')->where('user_id', Auth::user()->id)->paginate(15);
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
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
}
