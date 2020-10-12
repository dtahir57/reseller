<?php

namespace App\WordpressModels;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'wpjo_posts';
}
