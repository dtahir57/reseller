<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reseller_id')->unsigned();
            $table->unsignedBigInteger('order_id')->unsigned();
            $table->foreign('order_id')
                    ->references('id')
                    ->on('orders')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->integer('discounted_total')->nullable(); // customer ko discount dy kr jo total bana ha jo k nullable b ho skta ha
            $table->integer('order_total'); // yeh reseller ka apna total ha including all the discounts given by admin to reseller
            $table->integer('actual_earning'); // yeh actual order ka price ha
            $table->integer('actual_profit'); // final profit jo k 1 reseller ko huwa ha on each order
            $table->string('screenshot_url')->nullable();
            $table->string('status')->default('not_paid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('earnings');
    }
}
