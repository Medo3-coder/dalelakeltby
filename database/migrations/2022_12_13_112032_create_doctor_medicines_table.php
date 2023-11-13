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
        Schema::create('doctor_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->nullable()->references('id')->on('doctors')->onDelete('cascade');
            $table->string('image', 255)->nullable();
            $table->string('name', 255);
            $table->string('type', 255);
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
        Schema::dropIfExists('doctor_medicines');
    }
};
