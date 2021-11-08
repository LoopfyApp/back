<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('category_id');   
            $table->unsignedInteger('marca_id');      
            $table->string('photo')->nullable();     
            $table->string('codigo')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('ficha')->nullable();
            $table->string('price')->nullable();
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
        Schema::dropIfExists('products');
    }
}
