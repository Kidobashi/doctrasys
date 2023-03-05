<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('referenceNo');
            $table->bigInteger('senderOffice');
            $table->bigInteger('receiverOffice');
            $table->bigInteger('status');
            $table->string('prevReceiver')->nullable();
            $table->string('prevOffice')->nullable();
            $table->bigInteger('action')->nullable();
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
        Schema::dropIfExists('tracking_histories');
    }
};
