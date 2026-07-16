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
        Schema::create('permit_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unity_id');
            $table->foreign('unity_id')->references('id')->on('unities')->onDelete('cascade');
            $table->unsignedBigInteger('truck_id');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
            $table->string('carnet_number');
            $table->string('carnet_date');
            $table->string('status')->default('pending');
            $table->text('extras')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('permit_orders');
    }
};
