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
        Schema::create('product_additives', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->double('price');
            $table->double('discount_price')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_additive_category_id');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_additive_category_id')->references('id')->on('product_additive_categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('product_additives');
    }
};
