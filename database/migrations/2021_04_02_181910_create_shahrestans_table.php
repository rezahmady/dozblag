<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShahrestansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shahrestans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('ostan_id');
//            $table->foreign('ostan_id')->on('ostans');
            $table->string('amar_code')->nullable();
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
        Schema::dropIfExists('shahrestans');
    }
}
