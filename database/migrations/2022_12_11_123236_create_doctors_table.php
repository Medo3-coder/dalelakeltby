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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('doctors')->onDelete('cascade');
            $table->string('image', 50)->nullable();
            $table->string('name', 255);
            $table->string('nickname', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->text('qualifications')->nullable();
            $table->text('abstract')->nullable();
            $table->string('email')->nullable();
            $table->string('country_code', 5)->default('966');
            $table->string('phone');
            $table->string('password', 100);
            $table->integer('age')->nullable();
            // $table->decimal('examination_price')->nullable();
            $table->string('identity_number', 255)->nullable();
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
            $table->enum('is_approved', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->integer('code')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->foreignId('provider_rule_id')->nullable()->constrained('provider_rules')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('cascade');
            $table->decimal('average_rate')->default(0);
            $table->integer('count_rate')->default(0);
            $table->string('role_name')->nullable();
            // $table->foreignId('provider_rule_id')->nullable()->constrained('provider_rules')->onDelete('cascade');
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
        Schema::dropIfExists('doctors');
    }
};
