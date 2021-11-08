<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('nombre de la categorias');
            $table->integer('status')->default(1)->comment('Estatus 0.-Inactivo 1.-Activo');
            $table->string('logo')->comment('Logo de las categorias');  
            $table->integer('type')->comment('0.- Producto 1.-Servicios');
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
        Schema::dropIfExists('categories');
    }
}
