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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('fips', 2)->nullable();
            $table->string('iso', 2)->nullable();
            $table->string('en_name', 100)->nullable();
            $table->string('fa_name', 255)->nullable();
            $table->text('image')->nullable();
            $table->boolean('can_duplicate')->default(0);
            $table->bigInteger('amount')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('countries');
    }
};
