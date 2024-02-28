<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('garage_id')->on('users');
            $table->foreignId('car_license_id')->constrained();
            $table->foreignId('booking_service_id')->constrained();

            $table->string('maintenance_type');
            $table->date('maintenance_date');
            $table->boolean('parts_changed');
            $table->text('changed_parts')->nullable();
            $table->text('report_details')->nullable();
            $table->string('pdf')->nullable();                  // or image in media table
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
        Schema::dropIfExists('service_reports');
    }
}
