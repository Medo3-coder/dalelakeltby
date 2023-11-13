<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration {
  public function up() {
    Schema::create('admins', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('email')->unique();
      $table->string('phone')->unique();
      $table->string('password');
      $table->string('avatar', 50)->nullable();
      $table->integer('role_id')->default(0);
      $table->boolean('is_blocked')->default(0);
      $table->boolean('is_notify')->default(true);
      $table->decimal('wallet_balance', 9,2)->default(0);

      $table->softDeletes();
      $table->timestamps();
    });

    Admin::create([
      'name'     => 'Manager',
      'email'    => 'aait@info.com',
      'phone'    => '0555105813',
      'password' => 123456,
      'role_id'  => 1,
    ]);
  }

  public function down() {
    Schema::dropIfExists('admins');
  }
}
