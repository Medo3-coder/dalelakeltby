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
        Schema::create('pharmacy_branches', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->foreignId('pharmacist_id')->nullable()->constrained('pharmacists')->onDelete('cascade');
            $table->decimal('lat')->nullable();
            $table->decimal('lng')->nullable();
            $table->string('address', 150); 
            $table->string('address_map', 150);
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
        Schema::dropIfExists('pharmacy_branches');
    }
};
