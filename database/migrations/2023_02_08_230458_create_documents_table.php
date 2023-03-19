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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('senderOffice_id');
            $table->unsignedBigInteger('receiverOffice_id');
            $table->bigInteger('referenceNo');
            $table->bigInteger('status')->default(1);
            $table->bigInteger('docType');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('senderOffice_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('receiverOffice_id')->references('id')->on('offices')->onDelete('cascade');
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
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
