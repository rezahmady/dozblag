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
        Schema::create('trafic_permit_typeables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trafic_permit_type_id');
            $table->foreign('trafic_permit_type_id', 'trafic_permit_types')->references('id')->on('trafic_permit_types')->onDelete('cascade');
            $table->unsignedBigInteger('trafic_permit_typeable_id');
            $table->string('trafic_permit_typeable_type');
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
        Schema::dropIfExists('trafic_permit_typeables');
    }
};
