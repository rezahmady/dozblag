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
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('trafic_permit_template_id');
            $table->foreign('trafic_permit_template_id')->references('id')->on('trafic_permit_templates')->onDelete('cascade');
            $table->string('start_serial_number');
            $table->string('end_serial_number')->nullable();
            $table->integer('qty');
            $table->string('status');
            $table->string('year');
            $table->string('end_date');
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
        Schema::dropIfExists('repositories');
    }
};
