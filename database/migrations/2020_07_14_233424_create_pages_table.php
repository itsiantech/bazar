<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('navigation_location_id');
            $table->string('title');
            $table->longText('body');
            $table->string('banner_image')->nullable();
            $table->timestamps();

            $table->foreign('navigation_location_id')->references('id')->on('navigation_locations')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function($table)
        {

            $table->dropForeign(['navigation_location_id']);
            $table->dropColumn(['navigation_location_id']);
        });
        Schema::dropIfExists('pages');
    }
}
