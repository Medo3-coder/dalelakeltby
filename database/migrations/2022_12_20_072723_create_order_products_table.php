<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->unsignedBigInteger('offer_id')->nullable()->constrained('offers')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers');
            $table->foreignId('group_id')->nullable()->constrained('product_groups')->onDelete('cascade');
            $table->double('price')->default(0);
            $table->integer('qty')->default(0);
            $table->double('total_price')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('order_products');
    }
};
