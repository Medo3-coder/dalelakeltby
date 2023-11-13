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
        Schema::create('report_rates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');

            $table->unsignedBigInteger('report_num')->unique();

            $table->longText('report');

            $table->morphs('reportable');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('report_rates');
    }
};
