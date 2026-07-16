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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('amount');
            $table->unsignedBigInteger('unity_id');
            $table->foreign('unity_id')->references('id')->on('unities')->onDelete('cascade');
            $table->unsignedBigInteger('trafic_permit_export_id')->nullable();
            $table->foreign('trafic_permit_export_id')->references('id')->on('permit_order_trafic_permit');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
