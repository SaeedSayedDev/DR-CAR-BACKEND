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

            $table->string('start_date');
            $table->string('end_date');
            $table->string('day');

            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('garage_data');


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
