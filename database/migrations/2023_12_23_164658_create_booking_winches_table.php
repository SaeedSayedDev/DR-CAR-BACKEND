<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingWinchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_winches', function (Blueprint $table) {
            $table->id();
            $table->longText('address');
            $table->text('hint')->nullable();
            $table->integer('order_status_id')->default(1);

            
            $table->string('taxes')->nullable();
            $table->boolean('cancel')->default(0);
            $table->string('payment_stataus')->default('unpaid');
            $table->string('payment_amount');
            $table->string('payment_type')->nullable();
            $table->string('payment_id')->nullable();


            // $table->dateTime('start_at')->nullable();
            // $table->dateTime('ends_at')->nullable();
            // 'payment_id',

            $table->unsignedBigInteger('winch_id');
            $table->foreign('winch_id')->references('id')->on('users');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('booking_winches');
    }
}