<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\WordpressModels\Product;
use DB;
use App\Models\Order;
use Auth;
use App\Http\Requests\OrderRequest;
use App\Models\DiscountCode;
use App\Models\OrderHasProduct;
use Session;
use App\WordpressModels\OrderItem;
use App\WordpressModels\OrderItemMeta;
use App\WordpressModels\PostMeta;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->billing_first_name = $request->billing_first_name;
        $order->billing_last_name = $request->billing_last_name;
        $order->billing_company = $request->billing_company;
        $order->billing_address_1 = $request->billing_address_1;
        $order->billing_address_2 = $request->billing_address_2;
        $order->billing_city = $request->billing_city;
        $order->billing_state = $request->billing_state;
        $order->billing_postcode = $request->billing_postcode;
        $order->billing_country = $request->billing_country;
        $order->billing_email = $request->billing_email;
        $order->billing_phone = $request->billing_phone;
        $order->customer_name = $request->customer_name;
        $order->shipping_first_name = $request->shipping_first_name;
        $order->shipping_last_name = $request->shipping_last_name;
        $order->shipping_company = $request->shipping_company;
        $order->shipping_address_1 = $request->shipping_address_1;
        $order->shipping_address_2 = $request->shipping_address_2;
        $order->shipping_city = $request->shipping_city;
        $order->shipping_state = $request->shipping_state;
        $order->shipping_postcode = $request->shipping_postcode;
        $order->shipping_country = $request->shipping_country;
        $order->total_price = $request->total;
        if ((int) $request->discount > 0) {
            $order->discount = $request->discount;
            $calculate = ((int) $request->discount / 100) * (int) $request->total;
            $discounted_total = (int) $request->total - $calculate;
            $order->discounted_price = $discounted_total;
        }
        $order->save();
        foreach($request->product_id as $product) {
            $order_has_product = new OrderHasProduct;
            $order_has_product->product_id = $product;
            $order_has_product->order_id = $order->id;
            $order_has_product->save();
        }
        $this->store_wordpress_order($request);
        Session::flash('created', 'New Order Created Successfully!');
        return redirect()->route('order.index');
    }

    public function store_wordpress_order(Request $request)
    {
        $order = new Product;
        $order->post_author = 1;
        $order->post_date = Carbon::now();
        $order->post_date_gmt = Carbon::now();
        $order->post_content = ' ';
        $order->post_title = 'Order From Reseller '. Auth::user()->name;
        $order->post_excerpt = 'Order From Reseller '. Auth::user()->name;
        $order->post_status = 'shipping-by-blue-ex';
        $order->comment_status = 'open';
        $order->ping_status = 'closed';
        $order->post_password = 'wc_order'.$this->generateRandomString(20);
        $order->post_name = 'order-from-dashboard-'.Carbon::now();
        $order->to_ping = ' ';
        $order->pinged = ' ';
        $order->post_content_filtered = ' ';
        $order->post_modified = Carbon::now();
        $order->post_modified_gmt = Carbon::now();
        $order->post_parent = 0;
        $order->guid = 'https://rang-reza.com.pk';
        $order->menu_order = 0;
        $order->post_type = 'shop_order';
        $order->post_mime_type = ' ';
        $order->comment_count = 0;
        $order->save();
        foreach($request->product_id as $item_id) {
            $product = Product::where('post_type', 'product')->where('ID', $item_id)->first();
            $order_item = new OrderItem;
            // $order_item->order_item_id = $item_id;
            $order_item->order_item_name = $product->post_title;
            $order_item->order_item_type = 'shipping';
            $order_item->order_id = $order->id;
            $order_item->save();
                $order_item_meta = new OrderItemMeta;
                $order_item_meta->order_item_id = $order_item->id;
                $order_item_meta->meta_key = '_product_id';
                $order_item_meta->meta_value = $product->ID;
                $order_item_meta->save();

                $order_item_meta = new OrderItemMeta;
                $order_item_meta->order_item_id = $order_item->id;
                $order_item_meta->meta_key = '_line_subtotal';
                $order_item_meta->meta_value = $request->total;
                $order_item_meta->save();

                $order_item_meta = new OrderItemMeta;
                $order_item_meta->order_item_id = $order_item->id;
                $order_item_meta->meta_key = '_line_total';
                $order_item_meta->meta_value = $request->total;
                $order_item_meta->save();
        }
        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_first_name';
        $post_meta->meta_value = $request->billing_first_name;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_last_name';
        $post_meta->meta_value = $request->billing_last_name;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_company';
        $post_meta->meta_value = $request->billing_company;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_address_1';
        $post_meta->meta_value = $request->billing_address_1;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_address_2';
        $post_meta->meta_value = $request->billing_address_2;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_city';
        $post_meta->meta_value = $request->billing_city;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_first_name';
        $post_meta->meta_value = $request->billing_first_name;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_state';
        $post_meta->meta_value = $request->billing_state;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_postcode';
        $post_meta->meta_value = $request->billing_postcode;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_country';
        $post_meta->meta_value = $request->billing_country;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_email';
        $post_meta->meta_value = $request->billing_email;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_billing_phone';
        $post_meta->meta_value = $request->billing_phone;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_customer_user';
        $post_meta->meta_value = 0;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_first_name';
        $post_meta->meta_value = $request->shipping_first_name;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_last_name';
        $post_meta->meta_value = $request->shipping_last_name;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_company';
        $post_meta->meta_value = $request->shipping_company;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_address_1';
        $post_meta->meta_value = $request->shipping_address_1;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_address_2';
        $post_meta->meta_value = $request->shipping_address_2;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_city';
        $post_meta->meta_value = $request->shipping_city;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_state';
        $post_meta->meta_value = $request->shipping_state;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_postcode';
        $post_meta->meta_value = $request->shipping_postcode;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_country';
        $post_meta->meta_value = $request->shipping_country;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_email';
        $post_meta->meta_value = $request->shipping_email;
        $post_meta->save();

        $post_meta = new PostMeta;
        $post_meta->post_id = $order->id;
        $post_meta->meta_key = '_shipping_phone';
        $post_meta->meta_value = $request->shipping_phone;
        $post_meta->save();
    }

    public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
        $order = Order::find($id);
        $order_has_products = OrderHasProduct::where('order_id', $order->id)->get();
        foreach($order_has_products as $order) {
            $order->delete();
        }
        $order->delete();
        Session::flash('deleted', 'Order Deleted Successfully!');
        return redirect()->route('order.index');
    }

    public function search_products(Request $request)
    {
        $title = $request->title;
        $output = '<ul id="List">';
        if ($title) {
            $products = Product::where('post_title', 'like', "%$title%")->where('post_type', 'product')->get();
            foreach($products as $product) {
                $output .= '<li>
                                <a href="javascript:void(0)" onclick="getProduct('.$product->ID.', '.$request->divId.')">
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

    public function get_product(Request $request)
    {
        $product = Product::where('post_type', 'product')->where('ID', $request->id)->first();
        $price = $this->calculate_price($product);
        $output = '<div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">Product ID: '.$product->ID.'</div>
                                <div class="col-md-4">Product Title: '.$product->post_title.'</div>
                                <div class="col-md-4">Product Price: '.$price.'</div>
                            </div>
                        </div>
                   </div>
                   <a href="javascript:void(0)" onclick="search_product_again('.$request->divId.')">Click here to search product again</a>';
        
        $data = array('final' => $output, 'id' => $product->ID, 'price' => $price);

        return json_encode($data);
    }

    public function calculate_price($product)
    {
        $discounted_products = DiscountCode::where('reseller_id', Auth::user()->id)->pluck('product_id')->toArray();
        $price = DB::connection('mysql2')->table('wpjo_postmeta')->where('post_id', $product->ID)->where('meta_key', '_price')->first();
        if (in_array($product->ID, $discounted_products)) {
            $percentage = $product->discount;
            $total_price = (int) $price->meta_value;
            $calculate = ($percentage / 100) * $total_price;
            return $calculate;
        } else {
            return (int) $price->meta_value;
        }
    }
}
