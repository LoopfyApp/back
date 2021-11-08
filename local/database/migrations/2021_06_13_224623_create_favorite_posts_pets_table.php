<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritePostsPetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite_posts_pets', function (Blueprint $table) {
            $table->id();            
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('users_pets_id'); 
            $table->unsignedInteger('posts_pets_id'); 
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
        Schema::dropIfExists('favorite_posts_pets');
    }
}
