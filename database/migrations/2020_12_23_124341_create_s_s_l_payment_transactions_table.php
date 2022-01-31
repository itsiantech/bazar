<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSSLPaymentTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_s_l_payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('order_id')->default(0);
            $table->string('status',15)->nullable();
            $table->string('tran_id', 30)->nullable();
            $table->string('val_id', 50)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('store_amount', 10, 2)->nullable();
            $table->string('card_type', 50)->nullable();
            $table->string('card_no', 80)->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('bank_tran_id', 80)->nullable();
            $table->string('card_issuer', 50)->nullable();
            $table->string('card_brand', 50)->nullable();
            $table->string('card_issuer_country', 50)->nullable();
            $table->string('card_issuer_country_code', 2)->nullable();
            $table->string('currency_type', 3)->nullable();
            $table->decimal('currency_amount', 10, 2)->nullable();
            $table->text('test')->nullable();
            $table->dateTime('tran_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_s_l_payment_transactions');
    }
}
