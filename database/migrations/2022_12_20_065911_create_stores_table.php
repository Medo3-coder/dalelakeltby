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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
             $table->unsignedBigInteger('parent_id')->nullable();
             $table->string('role_name', 255)->nullable();
            $table->string('email');
            $table->string('password', 100);
            $table->string('image')->default('store.jpg');
            $table->string('phone');
            // $table->decimal('lat')->nullable();
            // $table->decimal('lng')->nullable();
            $table->string('code', 10)->nullable();
            $table->timestamp('code_expire')->nullable();
            $table->string('country_code', 5)->default('966');
            $table->string('identity_number',255)->nullable();
            $table->string('identity_image', 50)->default('identity_image.png');
            $table->boolean('is_blocked')->default(0);
            $table->boolean('is_active')->default(0);
            $table->double('delivery_price')->default(0);
            $table->enum('is_approved',['pending','accepted' , 'rejected'])->default('pending');
            $table->foreign('parent_id')->references('id')->on('stores')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('stores');
    }
};
