<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyInAvailabilityTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('availability_times', function (Blueprint $table) {
            $table->dropForeign(['provider_id']); // Drop existing foreign key constraint
            $table->foreign('provider_id')
                  ->references('id')
                  ->on('garage_data')
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
        Schema::table('availability_times', function (Blueprint $table) {
            //
        });
    }
}
