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
        Schema::create('product_feature_properities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_feature_id')->nullable()->references('id')->on('product_features')->onDelete('cascade');
            $table->foreignId('properity_id')->nullable()->references('id')->on('properities')->onDelete('cascade');
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
        Schema::dropIfExists('productfeatureproperities');
    }
};
