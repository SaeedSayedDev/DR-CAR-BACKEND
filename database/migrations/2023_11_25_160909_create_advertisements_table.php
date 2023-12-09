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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->integer('duration_by_day');
            $table->integer('promotion_type'); # company page => 1 , external link => 2
            $table->string('external_link')->nullable();
            $table->boolean('confirm')->default(false); # true Pay ads amount 
            $table->boolean('admin_approve')->nullable(); # not check Admin = 2 , not approve admin = 0, approve admin = 1 
            $table->date('start_date');
            $table->date('end_date');
            $table->string('invoice_id')->nullable();
            $table->string('amount')->default(0);

            $table->string('desc')->nullable();

            $table->boolean('admin_refund')->nullable(); # true Pay ads amount 

            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
