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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unity_id')->nullable();
            $table->foreign('unity_id')->references('id')->on('unities')->onDelete('cascade');
            // $table->unsignedBigInteger('trailer_id')->nullable();
            // $table->foreign('trailer_id')->references('id')->on('trailers')->onDelete('cascade');
            $table->unsignedBigInteger('vehicletype_id')->nullable();
            $table->foreign('vehicletype_id')->references('id')->on('vehicletypes')->onDelete('cascade');
            $table->string('transit_number');
            $table->string('iranian_plates_number');
            $table->string('model')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->text('extras')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('trucks');
    }
};
