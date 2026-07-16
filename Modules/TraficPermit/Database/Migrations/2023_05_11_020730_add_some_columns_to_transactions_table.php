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
        Schema::table('transactions', function (Blueprint $table) {
            $table->timestamp('date')->nullable()->after('status');
            $table->text('description')->nullable()->after('status');
            $table->string('transactionId')->nullable()->after('status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('transactionId');
            $table->dropColumn('description');
            $table->dropColumn('date');
        });
    }
};
