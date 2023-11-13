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
        Schema::create('store_branch_images', function (Blueprint $table) {
            $table->id();
            $table->string('image', 50)->nullable();
            $table->foreignId('store_id')->nullable()->references('id')->on('stores')->onDelete('cascade');
            $table->foreignId('store_branch_id')->nullable()->references('id')->on('store_branches')->onDelete('cascade');
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
        Schema::dropIfExists('store_branch_images');
    }
};
