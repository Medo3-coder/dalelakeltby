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
        Schema::create('sub_category_labs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_category_id')->constrained('lab_categories')->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained('lab_categories')->onDelete('cascade');
            $table->foreignId('lab_id')->constrained('labs')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->double('price', 9, 2);
            $table->string('unit');
            $table->string('normal_range');
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
        Schema::dropIfExists('sub_category_labs');
    }
};
