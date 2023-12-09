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
        Schema::create('status_order_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_order_id')->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->unique(['status_order_id', 'locale']);
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_order_translations');
    }
};
