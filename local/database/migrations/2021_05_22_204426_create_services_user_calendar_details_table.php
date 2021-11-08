<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesUserCalendarDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_user_calendar_details', function (Blueprint $table) {
            $table->id();            
            $table->unsignedInteger('users_id');
            $table->unsignedInteger('users_species');
            $table->unsignedInteger('user_services_id');
            $table->unsignedInteger('user_store_id');
            $table->unsignedInteger('services_user_calendars');
            $table->string('timer_orders')->nullable();
            $table->date('days_orders')->nullable();
            $table->float('amount')->nullable();

            $table->string('observation')->nullable();
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
        Schema::dropIfExists('services_user_calendar_details');
    }
}
