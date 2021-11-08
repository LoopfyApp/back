<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserServicesSpeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_services_species', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedInteger('user_services_id');
            $table->unsignedInteger('species_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('users_id');
            
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
        Schema::dropIfExists('user_services_species');
    }
}
