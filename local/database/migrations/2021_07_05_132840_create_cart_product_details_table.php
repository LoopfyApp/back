<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product_details', function (Blueprint $table) {
            $table->id();            
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('user_store_id');
            $table->unsignedInteger('cart_id');
            $table->unsignedInteger('id_products');
            $table->float('amount')->default(0);
            $table->integer('cantidad')->default(0);
            $table->string('observation')->nullable();
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
        Schema::dropIfExists('cart_product_details');
    }
}
