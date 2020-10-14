<?php

namespace App\WordpressModels;

use Illuminate\Database\Eloquent\Model;

class OrderItemMeta extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'wpjo_woocommerce_order_itemmeta';

    public $timestamps = false;
}
