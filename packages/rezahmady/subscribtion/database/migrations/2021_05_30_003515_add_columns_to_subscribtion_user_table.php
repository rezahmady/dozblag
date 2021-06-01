<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSubscribtionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscribtion_user', function (Blueprint $table) {
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscribtion_user', function (Blueprint $table) {
            $table->dropColumn('doctor_id');
            $table->dropColumn('room_id');
        });
    }
}
