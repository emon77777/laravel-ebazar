<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('image')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->integer('gender')->comment('0 = other, 1 = male, 2 = female');
            $table->string('address')->nullable();
            $table->string('business_address')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_mobile')->nullable();
            $table->string('post_code')->nullable();
            $table->string('city')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('domain_name')->nullable();
            $table->tinyInteger('domain_ssl_stat')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_approve')->default(0);
            $table->tinyInteger('is_suspended')->default(0);
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
        Schema::dropIfExists('sellers');
    }
}
