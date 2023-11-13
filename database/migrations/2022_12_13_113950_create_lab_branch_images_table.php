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
        Schema::create('lab_branch_images', function (Blueprint $table) {
            $table->id();
            $table->string('image', 100)->nullable();
            $table->foreignId('lab_branch_id')->nullable()->references('id')->on('lab_branches')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('lab_branch_images');
    }
};
