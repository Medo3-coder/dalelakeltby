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
        Schema::create('product_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('properities')->nullable();
            $table->string('image')->nullable();
            $table->text('desc')->nullable();
            $table->double('price');
            $table->double('discount_price')->nullable();
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->enum('in_stock_type',['in','out'])->default('in');
            $table->integer('in_stock_notification')->nullable();
            $table->integer('in_stock_qty')->nullable();
            $table->string('in_stock_sku')->nullable();
            $table->enum('appearance',['visible','invisible'])->default('visible');
            $table->enum('status',['posted','deleted'])->default('posted'); // 0 posted || 1 deleted

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
        Schema::dropIfExists('product_groups');
    }
};
