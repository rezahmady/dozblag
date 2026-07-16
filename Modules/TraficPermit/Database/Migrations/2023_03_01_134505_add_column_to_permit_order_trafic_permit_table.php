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
            $table->timestamp('get_carcasses_at')->nullable()->after('date');
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
            $table->dropColumn('get_carcasses_at');
        });
    }
};
