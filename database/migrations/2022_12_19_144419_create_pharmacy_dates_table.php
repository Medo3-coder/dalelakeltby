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
        Schema::create('pharmacy_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_branch_id')->nullable()->references('id')->on('pharmacy_branches')->onDelete('cascade');
            $table->string('day', 255);
            $table->time('from')->nullable();
            $table->time('to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pharmacy_dates');
    }
};
