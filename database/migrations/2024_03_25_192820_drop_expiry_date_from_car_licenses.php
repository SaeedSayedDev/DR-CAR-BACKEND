<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropExpiryDateFromCarLicenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_licenses', function (Blueprint $table) {
            $table->dropColumn('expiry_date');
            $table->dropColumn('registration_date');
            $table->dropColumn('registration_date');
        });
        Schema::table('car_licenses', function (Blueprint $table) {
            $table->string('expiry_date');
            $table->string('registration_date');
            $table->string('registration_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_licenses', function (Blueprint $table) {
            //
        });
    }
}
