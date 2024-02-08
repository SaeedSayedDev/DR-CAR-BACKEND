<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();

            $table->text('hint')->nullable();
            $table->smallInteger('quantity')->default(1);
            $table->integer('order_status_id')->default(1);
            $table->Text('coupon')->nullable();
            $table->boolean('as_soon_as')->default(1);
            $table->boolean('come_to_address_date')->nullable(); //required if as_soon_as false
            $table->dateTime('booking_at')->nullable();

            $table->string('taxes')->nullable();
            $table->boolean('cancel')->default(0);
            $table->string('payment_stataus')->default('unpaid');
            $table->string('payment_amount');
            $table->string('payment_type')->nullable();
            $table->string('payment_id')->nullable();

            $table->boolean('delivery_car')->default(false);

            // $table->dateTime('start_at')->nullable();
            // $table->dateTime('ends_at')->nullable();
            // 'payment_id',

            // $table->unsignedBigInteger('address_id');
            // $table->foreign('address_id')->references('id')->on('addresses');

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('booking_type')->default('garage');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_services');
    }
};
