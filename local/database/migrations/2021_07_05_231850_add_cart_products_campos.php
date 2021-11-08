<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCartProductsCampos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_products', function (Blueprint $table) {

            $table->string('amout_deliverys')->default(0);
            $table->string('cep_remitente')->nullable();
            $table->string('remitente')->nullable();
            $table->string('cep_destinatario')->nullable();
            $table->string('destinatario')->nullable();
            $table->string('note_adrress')->nullable();
            $table->string('subtotal')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
