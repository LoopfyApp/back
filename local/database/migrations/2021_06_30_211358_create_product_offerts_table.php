<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOffertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_offerts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('photo')->nullable();
            $table->float('price')->nullable();            
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->default(1)->comment('Estatus 0.-Inactivo 1.-Activo');
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
        Schema::dropIfExists('product_offerts');
    }
}
