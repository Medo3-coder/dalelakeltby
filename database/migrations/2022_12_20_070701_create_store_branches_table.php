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
        Schema::create('store_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->references('id')->on('stores')->onDelete('cascade');
            $table->string('name', 255);
            $table->decimal('lat')->nullable();
            $table->decimal('lng')->nullable();
            $table->string('address', 255);
            $table->string('address_map', 255)->nullable();
            $table->string('opening_certificate_image', 50)->nullable();
            $table->string('opening_certificate_pdf', 50)->nullable();
            $table->string('comerical_record', 255)->nullable(); 
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
        Schema::dropIfExists('store_branches');
    }
};
