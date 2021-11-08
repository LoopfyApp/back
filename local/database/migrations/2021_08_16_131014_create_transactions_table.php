<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();   
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('user_store_id');
            $table->string("cart_number");
            $table->integer("type");
            $table->string("url_boleto")->nullable();
            $table->string("payment_method");
            $table->text("transcations");
            $table->string("id_transaction");
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
        Schema::dropIfExists('transactions');
    }
}
