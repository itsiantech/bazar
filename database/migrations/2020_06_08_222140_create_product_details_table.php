<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->string('color')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_details', function($table)
        {
            $table->dropForeign(['product_id']);
            $table->dropColumn(['product_id']);
        });
        Schema::dropIfExists('product_details');
    }
}
