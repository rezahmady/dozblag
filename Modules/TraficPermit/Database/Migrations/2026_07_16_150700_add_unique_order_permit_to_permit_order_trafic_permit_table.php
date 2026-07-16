<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Prevents duplicate exports for the same permit order + trafic permit pair.
     * Run traficpermit:fix-duplicate-exports before migrating if duplicates exist.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permit_order_trafic_permit', function (Blueprint $table) {
            $table->unique(
                ['permit_order_id', 'trafic_permit_id'],
                'permit_order_trafic_permit_order_permit_unique'
            );
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
            $table->dropUnique('permit_order_trafic_permit_order_permit_unique');
        });
    }
};
