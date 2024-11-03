<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id');
            $table->uuid('user_id');
            $table->string('user_name');
            $table->string('user_role');
            $table->string('user_document');
            $table->string('product_brand');
            $table->string('product_model');
            $table->string('product_serial_number');
            $table->string('product_processor');
            $table->string('product_memory');
            $table->string('product_disk');
            $table->decimal('product_price', 10, 2);
            $table->string('product_price_string');
            $table->string('local');
            $table->date('date');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });

        Schema::table('documents', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
