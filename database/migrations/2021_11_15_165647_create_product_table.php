<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name');
            $table->string('unit');
            $table->string('tags');
            $table->integer('minimum_qty');
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();
            $table->tinyInteger('is_refundable')->default(0);
            $table->string('attributes')->nullable();
            $table->double('unit_price');
            $table->double('purchase_price');
            $table->double('sale_price');
            $table->double('discount');
            $table->integer('quantity');
            $table->integer('shipping_cost');
            $table->longText('description')->nullable();
            $table->string('pdf_specification')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('slug');
            $table->bigInteger('total_viewed')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->integer('publish_stat')->comment('0 = UnPublish, 1= Draft, 2=Published');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
