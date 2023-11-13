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
        Schema::create('lab_categories', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('image')->nullable();
            $table->boolean('has_targeted_body')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('lab_categories')->onDelete('cascade');
            $table->foreignId('lab_id')->nullable()->constrained('labs')->onDelete('cascade');
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
        Schema::dropIfExists('lab_categories');
    }
};
