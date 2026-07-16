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
            // $table->unsignedBigInteger('transaction_id')->nullable()->after('trafic_permit_id');
            // $table->boolean('payed')->default(0)->after('trafic_permit_id');
            $table->integer('amount')->default(0)->after('trafic_permit_id');
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
            $table->dropColumn('amount');
            // $table->dropColumn('payed');
            // $table->dropColumn('transaction_id');
        });
    }
};
