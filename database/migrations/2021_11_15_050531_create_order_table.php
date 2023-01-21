<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->integer('discount')->nullable();
            $table->integer('tax')->nullable();
            $table->integer('shipping_cost');
            $table->integer('total_price');
            $table->unsignedBigInteger('currency_id');
            $table->double('exchange_rate');
            $table->string('shipping_name');
            $table->string('shipping_address_1');
            $table->string('shipping_address_2')->nullable();
            $table->string('shipping_mobile')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_post')->nullable();
            $table->string('shipping_town')->nullable();
            $table->unsignedBigInteger('shipping_country_id')->nullable();
            $table->text('shipping_note')->nullable();
            $table->string('payment_by')->comment('paypal | cheque | cash | VISA | Master');
            $table->unsignedBigInteger('user_id');
            $table->string('user_first_name');
            $table->string('user_last_name');
            $table->string('user_address_1');
            $table->string('user_post_code')->nullable();
            $table->string('user_city')->nullable();
            $table->unsignedBigInteger('user_country_id');
            $table->string('user_mobile')->nullable();
            $table->string('user_email')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
