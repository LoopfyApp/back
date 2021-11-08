<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowPostsPetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_posts_pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('users_pets_id'); 
            $table->unsignedInteger('users_pets_follow_id'); 
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
        Schema::dropIfExists('follow_posts_pets');
    }
}
