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
        Schema::create('lab_branch_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_id')->nullable()->references('id')->on('labs')->onDelete('cascade');
            $table->foreignId('lab_branch_id')->nullable()->references('id')->on('lab_branches')->onDelete('cascade');
            $table->string('day')->nullable();
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
    public function down()
    {
        Schema::dropIfExists('lab_branch_dates');
    }
};
