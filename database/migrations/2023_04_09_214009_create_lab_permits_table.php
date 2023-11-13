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
        Schema::create('lab_permits', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('file');
            $table->unsignedBigInteger('lab_id');
            $table->foreign('lab_id')->references('id')->on('labs')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('lab_permits');
    }
};
