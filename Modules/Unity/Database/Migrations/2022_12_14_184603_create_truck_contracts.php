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
        Schema::create('truck_contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('truck_id');
            $table->foreign('truck_id')->references('id')->on('trucks')->onDelete('cascade');
            $table->unsignedBigInteger('unity_id');
            $table->foreign('unity_id')->references('id')->on('unities')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('start_date');
            $table->string('end_date')->nullable();
            $table->text('images')->nullable();
            $table->string('contract_status')->default('pending');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('truck_contracts');
    }
};
