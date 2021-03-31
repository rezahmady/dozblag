<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('prefix')->nullable();
            $table->string('label')->nullable();
            $table->string('type')->nullable();
            $table->string('cat')->nullable();
            $table->text('description')->nullable();
            $table->integer('theme_id')->unsigned();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('widgets');
    }
}
