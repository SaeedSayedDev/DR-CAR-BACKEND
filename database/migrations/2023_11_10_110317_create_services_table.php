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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('desc')->nullable();
            $table->decimal('price');
            $table->decimal('discount_price')->default(0);
            $table->boolean('price_unit')->comment("0 -> hourly, 1 -> fixed");
            $table->integer('quantity_unit')->default(1);
            $table->time('duration')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('enable_booking')->default(false);
            $table->boolean('available')->default(true);

            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
