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
        Schema::create('categories_labs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_category_id')->nullable()->constrained('lab_categories')->onDelete('cascade');
            $table->foreignId('lab_id')->nullable()->constrained('labs')->onDelete('cascade');
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
        Schema::dropIfExists('categories_labs');
    }
};
