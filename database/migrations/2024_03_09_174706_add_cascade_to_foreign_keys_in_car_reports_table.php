<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeToForeignKeysInCarReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('car_reports', function (Blueprint $table) {
            $table->dropForeign(['garage_id']);
            $table->dropForeign(['car_license_id']);
            $table->dropForeign(['booking_service_id']);

            $table->foreign('garage_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('car_license_id')
                ->references('id')->on('car_licenses')
                ->onDelete('cascade');

            $table->foreign('booking_service_id')
                ->references('id')->on('booking_services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_reports', function (Blueprint $table) {
            $table->dropForeign(['garage_id']);
            $table->dropForeign(['car_license_id']);
            $table->dropForeign(['booking_service_id']);

            $table->foreignId('garage_id')->constrained('users');
            $table->foreignId('car_license_id')->constrained();
            $table->foreignId('booking_service_id')->constrained();
        });
    }
}
