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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->longtext('diagnosis');
            $table->foreignId('reservation_id')->nullable()->references('id')->on('reservations')->onDelete('cascade');
            $table->foreignId('ragite_id')->nullable()->references('id')->on('ragites')->onDelete('cascade');
            $table->foreignId('chranic_disease_id')->nullable()->references('id')->on('chranic_diseases')->onDelete('cascade');
            $table->boolean('start_receipt')->default(0);
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
        Schema::dropIfExists('medical_records');
    }
};
