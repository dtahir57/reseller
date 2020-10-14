<?php

namespace App\WordpressModels;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'wpjo_postmeta';

    public $timestamps = false;
}
