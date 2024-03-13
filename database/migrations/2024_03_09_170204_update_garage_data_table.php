<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGarageDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garage_data', function (Blueprint $table) {
            $table->dropForeign(['garage_id']);

            $table->foreign('garage_id')
                ->references('id')->on('users')
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
            $table->dropForeign(['garage_id']);

            $table->foreign('garage_id')
                ->references('id')->on('users');
        });
    }
}
