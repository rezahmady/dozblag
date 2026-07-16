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
        Schema::table('permit_order_trafic_permit', function (Blueprint $table) {
            $table->boolean('is_recursive')->default(false)->after('get_carcasses_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permit_order_trafic_permit', function (Blueprint $table) {
            $table->dropColumn('is_recursive');
        });
    }
};
