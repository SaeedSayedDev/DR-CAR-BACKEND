<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailabilityTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availability_times', function (Blueprint $table) {
            $table->id();
            
            $table->date('start_data');
            $table->date('end_data');

            $table->unsignedBigInteger('garage_id');
            $table->foreign('garage_id')->references('id')->on('users');

            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id')->references('id')->on('week_days');

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
        Schema::dropIfExists('availability_times');
    }
}
