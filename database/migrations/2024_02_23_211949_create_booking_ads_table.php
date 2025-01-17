<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garage_id')->on('users');

            $table->unsignedInteger('display_duration');
            $table->tinyInteger('gender')->default(2);      // [0 => 'female', 1 => 'male', 2 => 'both']
            $table->string('coupon')->nullable();
            $table->float('amount')->default(0);
            $table->text('text')->nullable();
            // image in media table

            $table->string('car_type');
            $table->year('car_start_date');
            $table->year('car_end_date');

            $table->tinyInteger('status')->default(false);  // [0 => 'pending', 1 => 'approved', 2 => 'rejected', 3 => 'refunded']
            $table->boolean('display')->default(false);
            $table->date('display_start_date')->nullable();
            $table->date('display_end_date')->nullable();
            $table->text('rejection_reason')->nullable();

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
        Schema::dropIfExists('booking_ads');
    }
}
