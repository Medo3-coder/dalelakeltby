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
        Schema::create('sub_categories_labs_targeted_bodies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_category_lab_id')->constrained('sub_category_labs')->onDelete('cascade');
            $table->foreignId('target_body_id')->constrained('target_body_areas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sub_categories_labs_targeted_bodies');
    }
};
