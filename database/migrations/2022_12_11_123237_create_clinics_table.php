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
        Schema::create('clinics', function (Blueprint $table) {
            $table->id();
            $table->decimal('lat', 10, 8);
            $table->decimal('lng', 10, 8);
            $table->string('name');
            $table->string('address');
            $table->string('comerical_record');
            $table->double('detection_price', 9, 2);
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
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
        Schema::dropIfExists('clinics');
    }
};
