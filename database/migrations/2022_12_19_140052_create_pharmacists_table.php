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
        Schema::create('pharmacists', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('parent_id')->unsigned()->index()->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('pharmacists')->onDelete('cascade');
            $table->string('role_name')->nullable();
            $table->string('name', 255);
            $table->string('email')->nullable(); //
            $table->string('password', 100);
            $table->string('image')->nullable();
            $table->integer('age')->nullable();
            $table->string('phone');
            $table->string('country_code', 5)->default('966');
            $table->string('identity_number', 50)->nullable();
            $table->string('identity_image', 50)->nullable();
            $table->string('graduation_certification_image', 50)->nullable();
            $table->string('graduation_certification_pdf', 50)->nullable();
            $table->string('practice_certification_image', 50)->nullable();
            $table->string('practice_certification_pdf', 50)->nullable();
            $table->string('experience_certification_image', 50)->nullable();
            $table->string('experience_certification_pdf', 50)->nullable();
            $table->integer('experience_years')->nullable();
            $table->boolean('is_blocked')->default(0);
            $table->boolean('is_active')->default(0);
            $table->integer('code')->nullable();
            $table->enum('is_approved', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('cascade');
            $table->decimal('average_rate')->default(0);
            $table->integer('count_rate')->default(0);
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
        Schema::dropIfExists('pharmacists');
    }
};
