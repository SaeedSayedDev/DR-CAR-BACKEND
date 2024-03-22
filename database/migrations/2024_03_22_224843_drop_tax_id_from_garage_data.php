<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTaxIdFromGarageData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('garage_data', function (Blueprint $table) {
            $table->dropForeign(['tax_id']);

            $table->foreign('tax_id')
                ->references('id')->on('taxs')
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
        Schema::table('garage_data', function (Blueprint $table) {
            //
        });
    }
}
