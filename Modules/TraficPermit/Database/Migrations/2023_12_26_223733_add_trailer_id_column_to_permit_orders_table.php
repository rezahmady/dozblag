<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permit_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('trailer_id')->after('truck_id')->nullable();
            $table->foreign('trailer_id')->references('id')->on('trailers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permit_orders', function (Blueprint $table) {
            $table->dropColumn('trailer_id');
        });
    }
};
