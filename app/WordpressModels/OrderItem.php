<?php

namespace App\WordpressModels;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'wpjo_woocommerce_order_items';

    public $timestamps = false;
}
