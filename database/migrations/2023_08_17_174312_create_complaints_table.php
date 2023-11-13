<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration {

    public function up() {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->longText('complaint', 500)->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('complaints');
    }
}
