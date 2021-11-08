<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesUserCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_user_calendars', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('user_store_id'); 
            $table->string('cart_number');
            $table->integer('status_pay')->default('0');
            $table->string('number_transaction');
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
        Schema::dropIfExists('services_user_calendars');
    }
}
