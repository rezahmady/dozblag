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
        Schema::create('permit_order_trafic_permit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permit_order_id');
            $table->foreign('permit_order_id')->references('id')->on('permit_orders')->onDelete('cascade');
            $table->unsignedBigInteger('trafic_permit_id');
            $table->foreign('trafic_permit_id')->references('id')->on('trafic_permits')->onDelete('cascade');
            $table->string('status')->default(0);
            $table->timestamp('date');
            $table->text('extras')->nullable();
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
        Schema::dropIfExists('permit_order_trafic_permit');
    }
};
