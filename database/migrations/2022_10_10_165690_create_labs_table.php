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
        Schema::create('labs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('parent_id')->nullable()->constrained('labs')->onDelete('cascade');
            $table->string('role_name')->nullable();

            $table->string('name');
            $table->string('phone', 15);
            $table->string('password');
            $table->string('country_code', 5)->default('966');
            $table->string('email', 50)->nullable();
            $table->string('image', 100)->nullable();
            $table->string('identity_id')->default(0);
            $table->string('identity_image', 100)->nullable();
            $table->string('lab_name')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_blocked')->default(0);
            $table->integer('code')->nullable();
            $table->boolean('is_active')->default(0);
            $table->enum('is_approved', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->decimal('rate_avg')->default(0);
            $table->integer('rate_count')->default(0);
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');

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
        Schema::dropIfExists('labs');
    }
};
