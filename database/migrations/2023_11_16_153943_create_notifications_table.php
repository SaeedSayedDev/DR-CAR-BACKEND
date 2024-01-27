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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('creator_name');
            $table->unsignedBigInteger('type_id');
            $table->string('text_en');
            $table->string('text_ar');
            $table->string('notification_type_en');
            $table->string('notification_type_ar');
            $table->string('api');
            $table->boolean('read')->default(0);
            

            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
