<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveProviderIdFromNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('notifications', function (Blueprint $table) {
        //     //           
        //     $table->dropForeign(['provider_id']);
        //     $table->dropColumn('provider_id');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users');
        });
    }
}
