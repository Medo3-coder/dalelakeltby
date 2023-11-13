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
        Schema::create('lab_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_id')->nullable()->references('id')->on('labs')->onDelete('cascade');
            $table->decimal('lat')->nullable();
            $table->decimal('lng')->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('address_map');
            $table->string('opening_certificate_image', 100)->nullable();
            $table->string('opening_certificate_pdf', 100)->nullable();
            $table->string('comerical_record')->nullable();
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->onDelete('cascade');
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
        Schema::dropIfExists('lab_branches');
    }
};
