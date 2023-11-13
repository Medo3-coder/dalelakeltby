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
        Schema::create('lab_tests', function (Blueprint $table) {

            $table->id();

            $table->foreignId('sub_category_lab_id')->constrained('sub_category_labs')->onDelete('cascade');
            $table->string('name');
            $table->double('price', 9, 2);
            $table->string('normal_range');
            $table->string('unit');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('lab_tests');
    }
};
