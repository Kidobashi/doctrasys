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
        Schema::create('basis_of_returns', function (Blueprint $table) {
            $table->id();
            $table->string('referenceNumber');
            $table->unsignedBigInteger('primary_reason_of_return_id')->references('id')->on('reasons_for_return')->onDelete('cascade')->nullable();
            $table->string('lacking_doc_id')->nullable();
            $table->text('others')->nullable();
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
        Schema::dropIfExists('basis_of_returns');
    }
};
