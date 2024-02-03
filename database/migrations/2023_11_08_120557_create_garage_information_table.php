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
        Schema::create('garage_information', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('short_biography')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('garage_type');

            $table->unsignedBigInteger('garage_id');
            $table->foreign('garage_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garage_information');
    }
};
