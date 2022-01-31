<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserDeleteRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_delete_requests', function ($table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('algorithm', 10)->default('sha256');
            $table->string('expires', 191);
            $table->string('confirmation_code', 40);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_delete_requests');

    }
}
