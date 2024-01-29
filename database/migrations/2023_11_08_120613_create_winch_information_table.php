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
        Schema::create('winch_information', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('short_biography')->nullable();
            $table->string('KM_price')->nullable();
            $table->string('availability_range')->nullable();

            $table->timestamp('phone_verified_at')->nullable();
            $table->boolean('available_now')->default(0);

            $table->unsignedBigInteger('winch_id');
            $table->foreign('winch_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winch_information');
    }
};
