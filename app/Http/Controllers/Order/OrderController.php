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
use App\woocommerce\src\WooCommerce\Client;
use App\Models\Earning;
use App\Http\Requests\OrdersRequest;
use Rap2hpoutre\FastExcel\FastExcel;
use App\User;
use App\Models\City;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = [];
        if (Auth::user()->hasRole('Super_User')) {
            $orders = DB::table('orders')->paginate(15);
        } else {
            $orders = DB::table('orders')->where('user_id', Auth::user()->id)->paginate(15);
        }
        $woocommerce = new Client(
            'https://rang-reza.com.pk/',
            config('app.consumer_key'),
            config('app.consumer_secret'),
            [
                'wp_api' => true,
                'version' => 'wc/v3',
                'query_string_auth' => true,
                'verify_ssl' => false
            ]
        );
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('orders.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        // dd($request->qty);
        $actual_earning = array_sum($request->actual_price);
        $calculate = null;
        $order_total = (int) $request->total;
        $reseller_discount = Auth::user()->discount;
        // Create New Order

        $total_price = 0;
        $t_price = 0;
        for($i = 0; $i < count($request->product_price); $i++) {
            $per_product_price = $request->product_price[$i] * $request->qty[$i];
            $total_price = $t_price + $per_product_price;
        }
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->billing_first_name = $request->billing_first_name;
        $order->billing_last_name = $request->billing_last_name;
        $order->billing_company = $request->billing_company;
        $order->billing_address_1 = $request->billing_address_1;
        $order->billing_address_2 = $request->billing_address_2;
        // $order->billing_city = $request->billing_city;
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
        // $order->shipping_city = $request->shipping_city;
        $order->shipping_state = $request->shipping_state;
        $order->shipping_postcode = $request->shipping_postcode;
        $order->shipping_country = $request->shipping_country;
        $order->billing_city_id = $request->billing_city;
        $order->shipping_city_id = $request->shipping_city;
        $order->total_price = $total_price + 250;
        if ((int) $request->discount > 0) {
            $order->discount = $request->discount;
            $calculate = ((int) $request->discount / 100) * (int) $request->total;
            $discounted_total = (int) $request->total - $calculate;
            $order->discounted_price = $discounted_total + 250;
        }
        $order->save();
        for($i = 0; $i < count($request->product_id); $i++) {
            $order_has_product = new OrderHasProduct;
            $order_has_product->product_id = $request->product_id[$i];
            $order_has_product->qty = $request->qty[$i];
            $order_has_product->order_id = $order->id;
            $order_has_product->save();
        }
        $w_order = $this->store_wordpress_order($request, $total_price);
        // dd($w_order->id);
        $s_order = Order::find($order->id);
        $s_order->order_id = $w_order->id;
        $s_order->update();
        $earning = new Earning;
        $earning->reseller_id = Auth::user()->id;
        $earning->order_id = $order->id;
        $earning->order_total = $order_total;
        $earning->actual_earning = $actual_earning;
        if ($calculate) {
            $u_cal = 0;
            if (Auth::user()->discount) {
                $u_cal = ((int) Auth::user()->discount / 100) * $discounted_total;
                $u_total = $discounted_total - $u_cal;
            }
            $earning->discounted_total = $order->discounted_price;
            $earning->actual_profit = $actual_earning - $order_total - $calculate - $u_cal;
        } else {
            $u_cal = 0;
            if (Auth::user()->discount) {
                $u_cal = ((int) Auth::user()->discount / 100) * $order_total;
                $u_total = $order_total - $u_cal;
            }
            $earning->actual_profit = $actual_earning - $order_total - $u_cal;
        }
        $earning->save();

        $u_earning = Earning::find($earning->id);
        $reseller = User::find(Auth::user()->id);
        $reseller->balance = $reseller->balance + $u_earning->actual_profit;
        $reseller->update();
        
        Session::flash('created', 'New Order Created Successfully!');
        return redirect()->route('order.index');
    }

    public function store_wordpress_order(Request $request, $total_price)
    {
        $line_items = [];
        for($i = 0; $i < count($request->product_id); $i++) {
            $line_items[$i]['product_id'] = $request->product_id[$i];
            $line_items[$i]['quantity'] = $request->qty[$i];
        }
        $data = [
            'payment_method' => 'cod',
            'status' => 'processing',
            'payment_method_title' => 'Cash On Delivery',
            'set_paid' => false,
            'billing' => [
                'first_name' => $request->billing_first_name,
                'last_name' => $request->billing_last_name,
                'address_1' => $request->billing_address_1,
                'address_2' => $request->billing_address_2,
                'city' => $request->billing_city,
                'state' => $request->billing_state,
                'postcode' => $request->billing_postcode,
                'country' => $request->billing_country,
                'email' => $request->billing_email,
                'phone' => $request->billing_phone
            ],
            'shipping' => [
                'first_name' => $request->shipping_first_name,
                'last_name' => $request->shipping_last_name,
                'address_1' => $request->shipping_address_1,
                'address_2' => $request->shipping_address_2,
                'city' => $request->shipping_city,
                'state' => $request->shipping_state,
                'postcode' => $request->shipping_postcode,
                'country' => $request->shipping_country
            ],
            'line_items' => $line_items,
            'shipping_lines' => [
                [
                    'method_id' => 'flat_rate',
                    'method_title' => 'Delivery Charges',
                    'total' => "250"
                ]
            ]
        ];
        $woocommerce = new Client(
            'https://rang-reza.com.pk/',
            config('app.consumer_key'),
            config('app.consumer_secret'),
            [
                'wp_api' => true,
                'version' => 'wc/v3',
                'query_string_auth' => true,
                'verify_ssl' => false
            ]
        );
        $order = $woocommerce->post('orders', $data);
        return $order;
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
        $postmeta = DB::connection('mysql2')->table('wpjo_postmeta')->where('post_id', $product->ID)->where('meta_key', '_price')->first();
        $actual_price = (int) $postmeta->meta_value;
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

        $data = array('final' => $output, 'id' => $product->ID, 'price' => (int) $price, 'actual_price' => $actual_price);

        return json_encode($data);
    }

    public function calculate_price($product)
    {
        $discounted_products = DiscountCode::where('reseller_id', Auth::user()->id)->pluck('product_id')->toArray();
        $price = DB::connection('mysql2')->table('wpjo_postmeta')->where('post_id', $product->ID)->where('meta_key', '_price')->first();
        if (in_array($product->ID, $discounted_products)) {
            $discount = DiscountCode::where('reseller_id', Auth::user()->id)->where('product_id', $product->ID)->first();
            $percentage = (int) $discount->discount;
            $total_price = (int) $price->meta_value;
            $calculate = ($percentage / 100) * $total_price;
            return $total_price - $calculate;
        } else {
            return (int) $price->meta_value;
        }
    }

    public function delivered_orders(OrdersRequest $request)
    {
        $path = $request->file('orders')->getRealPath();
        $collection = (new FastExcel)->import($path);
        foreach($collection as $key => $val) {
            $order = Order::where('order_id', $val['Order ID'])->first();
            if ($order) {
                $order->status = 'delivered';
                $order->update();
            } else {
            break;
            }
        }
        Session::flash('uploaded', 'Delivered Orders Upload!');
        return redirect()->route('order.index');
    }

    public function returned_orders(OrdersRequest $request)
    {
        $path = $request->file('orders')->getRealPath();
        $collection = (new FastExcel)->import($path);
        foreach($collection as $key => $val) {
            $order = Order::where('order_id', $val['Order ID'])->first();
            if ($order) {
                $order->status = 'returned';
                $order->update();
            } else {
            break;
            }
        }
        Session::flash('uploaded', 'Returned Orders Upload!');
        return redirect()->route('order.index');
    }
}
