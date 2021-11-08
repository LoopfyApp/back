<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposServicesModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_services', function (Blueprint $table) {
   
            $table->string('time')->nullable();  
            $table->string('time_open')->nullable(); 
            $table->string('time_close')->nullable();  
            $table->string('time_open_descanso')->nullable();  
            $table->string('time_close_descanso')->nullable();  
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
