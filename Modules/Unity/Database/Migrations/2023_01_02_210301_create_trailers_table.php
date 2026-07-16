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
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unity_id')->nullable();
            $table->foreign('unity_id')->references('id')->on('unities')->onDelete('cascade');
            $table->unsignedBigInteger('vehicletype_id')->nullable();
            $table->foreign('vehicletype_id')->references('id')->on('vehicletypes')->onDelete('cascade');
            $table->unsignedBigInteger('truck_id');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->string('transit_number');
            $table->string('iranian_plates_number');
            $table->string('model')->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('trailers');
    }
};
