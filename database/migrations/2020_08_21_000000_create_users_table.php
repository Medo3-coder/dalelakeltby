<?php

use App\View\Components\Admin\table;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
  public function up() {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name',50);
      $table->string('country_code',5)->default('966');
      $table->string('phone',15);
      $table->string('email',50)->nullable();
      $table->integer('age')->nullable();
      $table->string('password',100);
      $table->boolean('has_diseases')->default(false);
      $table->string('image', 50);
      $table->boolean('active')->default(0);
      $table->decimal('weight',45)->default(0);
      $table->decimal('height',45)->default(0);
      $table->enum('gender',['male' , 'female'])->nullable();
      $table->boolean('is_blocked')->default(0);
      $table->boolean('is_approved')->default(1);
      $table->string('lang', 3)->default('ar');
      $table->boolean('is_notify')->default(true);
      $table->string('code', 10)->nullable();
      $table->foreignId('blood_type_id')->nullable()->references('id')->on('blood_types')->onDelete('cascade');
      $table->timestamp('code_expire')->nullable();
      $table->decimal('lat')->nullable();
      $table->decimal('lng')->nullable();
      $table->string('map_desc', 50)->nullable();
      $table->decimal('wallet_balance', 9,2)->default(0);
      $table->softDeletes();
      $table->timestamp('created_at')->useCurrent();
      $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
    });
  }

  public function down() {
    Schema::dropIfExists('users');
  }
}
