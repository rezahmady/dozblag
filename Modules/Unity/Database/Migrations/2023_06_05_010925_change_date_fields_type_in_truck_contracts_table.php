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
        Schema::table('truck_contracts', function (Blueprint $table) {
            $table->timestamp('start_date')->change();
            $table->timestamp('end_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('truck_contracts', function (Blueprint $table) {
            $table->string('start_date')->change();
            $table->string('end_date')->change();
        });
    }
};
