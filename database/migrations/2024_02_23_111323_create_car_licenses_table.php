<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_licenses', function (Blueprint $table) {
            $table->id();
            # User
            $table->foreignId('user_id')->constrained();
            $table->string('owner_en');
            $table->string('owner_ar')->nullable();
            $table->string('nationality_en');
            $table->string('nationality_ar')->nullable();
            # Vehicle
            $table->unsignedInteger('number_of_passengers');
            $table->string('model');
            $table->string('origin_en');
            $table->string('origin_ar')->nullable();
            $table->string('color');
            $table->string('class');
            $table->string('type_en');
            $table->string('type_ar')->nullable();
            $table->string('gross_weight');
            $table->string('empty_weight');
            $table->string('engine_number');
            $table->string('chassis_number');
            # Vehicle License
            $table->string('traffic_code_number')->unique();
            $table->string('traffic_plate_number')->unique();
            $table->string('plate_class');
            $table->string('place_of_issue');
            $table->date('expiry_date');
            $table->date('registration_date');
            $table->date('insurance_expiry');
            $table->string('policy_number');
            $table->string('insured_company');
            $table->string('insurance_type');
            $table->string('mortgaged_by')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('car_licenses');
    }
}
