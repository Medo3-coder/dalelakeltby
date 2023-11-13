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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['offer', 'product']);

            $table->foreignId('lab_id')->nullable()->constrained('labs')->onDelete('cascade');
            $table->foreignId('pharmacy_id')->nullable()->constrained('pharmacists')->onDelete('cascade');
            $table->foreignId('store_id')->nullable()->constrained('stores')->onDelete('cascade');

            $table->foreignId('offer_id')->nullable()->constrained('offers')->onDelete('cascade');
            $table->integer('qty')->nullable();

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
        Schema::dropIfExists('carts');
    }
};
