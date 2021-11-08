<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('category_id');        
            $table->string('photo')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('user_services');
    }
}
