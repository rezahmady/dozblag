<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unities', function (Blueprint $table) {
            $table->id();
            $table->string('fa_name');
            $table->string('en_name');
            $table->string('national_id');
            $table->string('registration_number')->nullable();
            $table->string('registration_date')->nullable();
            $table->unsignedBigInteger('shahrestan_id')->nullable();
            $table->foreign('shahrestan_id')->references('id')->on('shahrestans')->onDelete('cascade');
            $table->unsignedBigInteger('ostan_id')->nullable();
            $table->foreign('ostan_id')->references('id')->on('ostans')->onDelete('cascade');
            $table->string('tell')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('en_address')->nullable();
            $table->text('fa_address')->nullable();
            $table->string('description')->nullable();
            $table->string('status')->default('inactive');
            $table->text('extras')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('unities');
    }
}
