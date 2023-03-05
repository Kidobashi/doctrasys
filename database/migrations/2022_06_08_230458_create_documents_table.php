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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('referenceNo');
            $table->string('email');
            $table->string('senderName');
            $table->unsignedBigInteger('senderOffice_id');
            $table->unsignedBigInteger('receiverOffice_id');
            $table->foreign('senderOffice_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('receiverOffice_id')->references('id')->on('offices')->onDelete('cascade');
            $table->bigInteger('status')->default(1);
            $table->bigInteger('docType');
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
        Schema::dropIfExists('documents');
    }
};
