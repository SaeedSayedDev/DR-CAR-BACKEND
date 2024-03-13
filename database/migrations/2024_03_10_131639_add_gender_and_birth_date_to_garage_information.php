<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGenderAndBirthDateToGarageInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garage_information', function (Blueprint $table) {
            $table->integer('gender')->nullable()->comment("1 -> female, 2 -> male");
            $table->string('birth_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garage_information', function (Blueprint $table) {
            //
        });
    }
}
