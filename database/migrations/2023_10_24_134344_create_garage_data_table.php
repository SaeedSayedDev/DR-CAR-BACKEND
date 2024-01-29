<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarageDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garage_data', function (Blueprint $table) {
            $table->id();
            $table->integer('availability_range');
            $table->boolean('garage_type')->comment("0 -> private, 1 -> company");

            $table->unsignedBigInteger('tax_id');
            $table->foreign('tax_id')->references('id')->on('taxes');

            $table->unsignedBigInteger('garage_id');
            $table->foreign('garage_id')->references('id')->on('users');
            
            $table->unsignedBigInteger('check_servic_id');

            


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
        Schema::dropIfExists('garage_data');
    }
}