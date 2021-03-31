<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('caption')->nullable();
            $table->text('description')->nullable();
            $table->json('content')->nullable();
            $table->json('parameters')->nullable();
            $table->json('metas')->nullable();
            $table->json('gallery')->nullable();
            $table->string('type')->nullable();
            $table->json('type_data')->nullable();
            $table->json('settings')->nullable();
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
        Schema::drop('products');
    }
}
