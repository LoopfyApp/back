<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();            
            $table->string('name')->comment('nombre de la subcategorias');
            $table->integer('status')->default(1)->comment('Estatus 0.-Inactivo 1.-Activo');
            $table->string('logo')->comment('Logo de las subcategorias');   
            $table->unsignedInteger('categories_id')->nullable();            
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
        Schema::dropIfExists('subcategories');
    }
}
