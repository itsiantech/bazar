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
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('name_en');
            $table->string('name_bn');
            $table->text('description_en')->nullable();
            $table->text('description_bn')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('price_en');
            $table->string('price_bn');
            $table->integer('quantity');
            $table->string('unit');
            //text_percent changed to sold_amount.
            $table->integer( 'sold_amount')->nullable();
            $table->integer('vat_percent')->nullable();
            $table->integer('discount')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_deleted')->default(0);
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');

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
            $table->dropForeign(['owner_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['discount_id']);
            $table->dropColumn(['owner_id','category_id','brand_id','discount_id']);
        });
        Schema::dropIfExists('products');
    }
}
