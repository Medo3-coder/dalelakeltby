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
        Schema::create('medical_record_medicans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->nullable()->references('id')->on('medical_records')->onDelete('cascade');
            $table->foreignId('doctor_medican_id')->nullable()->references('id')->on('doctor_medicines')->onDelete('cascade');
            $table->decimal('hours');
            $table->integer('times');
            $table->foreignId('reservation_id')->nullable()->references('id')->on('reservations')->onDelete('cascade');
            $table->timestamp('next_time')->nullable();
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
        Schema::dropIfExists('medical_record_medicans');
    }
};
