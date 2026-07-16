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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('national_id')->index();
            $table->unsignedBigInteger('unity_id');
            $table->foreign('unity_id')->references('id')->on('unities')->onDelete('cascade');
            $table->string('fa_name');
            $table->string('en_name');
            $table->string('mobile')->nullable();
            $table->text('images')->nullable();
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
        Schema::dropIfExists('drivers');
    }
};
