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
        Schema::create('store_coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id');
            $table->string('code');
            $table->enum('type', ['ratio', 'number']);
            $table->double('discount');
            $table->double('max_discount')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->integer('max_use');
            $table->integer('use_times')->default(0);
            $table->enum('status', ['available', 'expire' , 'usage_end' , 'closed']);
            $table->foreign('store_id')->references('id')->on('stores')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('store_coupons');
    }
};
