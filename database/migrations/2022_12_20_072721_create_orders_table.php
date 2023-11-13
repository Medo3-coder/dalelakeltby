<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lab_id')->nullable()->references('id')->on('labs')->onDelete('cascade');
            $table->foreignId('pharmacist_id')->nullable()->references('id')->on('pharmacists')->onDelete('cascade');
            $table->foreignId('store_id')->nullable()->references('id')->on('stores')->onDelete('cascade');
            $table->foreignId('pharmacy_branch_id')->nullable()->references('id')->on('pharmacy_branches')->onDelete('cascade');
            $table->foreignId('lab_branch_id')->nullable()->references('id')->on('lab_branches')->onDelete('cascade');

            $table->enum('payment_type', ['installment', 'cash', 'online'])->nullable(); // طرق الدفع
            $table->enum('payment_status', ['pending', 'paid'])->default('pending'); // حالة الدفع
            $table->enum('receiving_method', ['by_delegate', 'on_arrival'])->nullable();
            $table->enum('status', ['pending', 'accepted', 'prepared', 'rejected', 'canceled'])->default('pending');
            $table->enum('status_installment', ['pending', 'finished'])->default('pending');
            $table->enum('online_type', ['zain', 'asia', 'master', 'visa'])->default('visa');

            $table->string('order_num')->unique();
            $table->decimal('deliver_lat')->nullable();
            $table->decimal('deliver_lng')->nullable();
            $table->string('address')->nullable();
            $table->date('deliver_date')->nullable(); // تاريخ التسليم المحتمل
            $table->string('prepare_time')->nullable(); // مدة التجهيز

            $table->longText('cancel_reason')->nullable(); // سبب الرفض

            $table->double('vat_amount')->default(0);
            $table->double('vat_ratio')->default(0);
            $table->double('final_total')->nullable(); //الاجمالي
            $table->double('total_price')->nullable(); // الاجمالي الفرعي
            $table->double('delivery_price')->nullable(); // سعر التوصيل
            $table->string('coupon')->nullable(); // كبون الخصم
            $table->string('discount')->nullable(); // الخصم

            $table->integer('installment_days')->nullable();
            $table->integer('installment_number')->nullable();

            $table->integer('admin_commission_ratio')->default('0'); // نسبة عمولة الادارة
            $table->decimal('admin_commission_amount')->nullable(); // قيمة عمولة الادارة
            $table->text('notes')->nullable();

            $table->softDeletes();

            $table->timestamps();

        });
    }

    public function down() {
        Schema::dropIfExists('orders');
    }
}
