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
        Schema::create('trafic_permits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repository_id');
            $table->foreign('repository_id')->references('id')->on('repositories')->onDelete('cascade');
            $table->string('serial_number');
            $table->string('status');
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('trafic_permits');
    }
};
