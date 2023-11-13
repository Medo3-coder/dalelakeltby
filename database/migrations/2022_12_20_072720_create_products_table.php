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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_num', '199')->nullable();
            $table->date('date_of_supply')->nullable();
            $table->string('effective_material', '199')->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('desc')->nullable();
            $table->enum('type',['simple','multiple'])->default('simple');
            $table->enum('category_type',['medicine','equipment'])->default('medicine');
            $table->enum('available',['true','false'])->default('true');
            $table->integer('counter')->default(0);
            $table->foreignId('product_category_id')->nullable()->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreignId('store_id')->nullable()->references('id')->on('stores')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
