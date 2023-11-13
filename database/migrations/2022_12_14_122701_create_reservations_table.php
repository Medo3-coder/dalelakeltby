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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // when the doctor transfer to lab this is the doctor reservation id on the lab reservation
            $table->foreignId('parent_id')->nullable()->constrained('reservations')->onDelete('cascade');

            $table->decimal('lat')->nullable(); // خط الطول
            $table->decimal('lng')->nullable(); // خط العرض
            $table->date('date')->nullable(); // تاريخ الحجز
            $table->time('time')->nullable(); // وقت الحجز
            $table->longText('details'); // تفاصيل الطلب
            $table->enum('type', ['doctor', 'lab'])->default('doctor');

            // check that reservation for auth user or for family
            $table->enum('reservation_for', ['same_person', 'family'])->default('same_person'); // الحجز لنفس الشخص او لشخص اخر
            $table->string('paient_name', 50)->nullable(); // اسم المريض
            $table->integer('paient_age')->nullable(); // عمر المريض
            $table->integer('paient_weight')->nullable(); // وزن المريض
            $table->integer('paient_height')->nullable(); // طول المريض
            $table->enum('paient_gender', ['male', 'female'])->nullable(); // جنس المريض
            // check that reservation for auth user or for family

            // pricing
            $table->decimal('reservation_price')->nullable(); // سعر الحجز
            $table->decimal('detection_price')->nullable(); //  سعر الكشف
            $table->decimal('analysis_price')->nullable(); //  مجموع سعر التحاليل
            $table->integer('admin_commission_ratio')->default('0'); // نسبة عمولة الادارة
            $table->decimal('admin_commission_amount')->nullable(); // قيمة عمولة الادارة
            $table->integer('vat_rate_ratio')->default('0'); // نسبة القيمة المضافة
            $table->decimal('vat_rate_amount')->nullable(); // القيمة المضافة
            $table->decimal('total_price')->nullable(); // السعر الاجمالي
            $table->decimal('final_total')->nullable(); // السعر الكلي
            // priceing

            // lab report
            $table->longText('lab_report')->nullable();

            $table->enum('status', ['new', 'approved', 'on_progress', 'transfer_to_lab', 'lab_send_results', 'finished', 'rejected', 'canceled'])->default('new'); // حالة الحجز
            $table->enum('payment_method', ['wallet', 'sms']); // طريقة الدفع
            $table->enum('payment_status', ['pending', 'paid']); // حالة الدفع
            $table->foreignId('cancel_reason_id')->nullable()->constrained('cancel_reasons'); // سبب الرفض

            $table->string('rate')->nullable(); // التقييم
            $table->longText('comment')->nullable(); // التعليق

            $table->unsignedBigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('doctor_id')->unsigned()->index()->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');

            $table->unsignedBigInteger('clinic_id')->unsigned()->index()->nullable();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('cascade');

            $table->unsignedBigInteger('paient_blood_type_id')->unsigned()->index()->nullable(); // فصيلة الدم
            $table->foreign('paient_blood_type_id')->references('id')->on('blood_types')->onDelete('cascade');

            $table->unsignedBigInteger('lab_id')->unsigned()->index()->nullable();
            $table->foreign('lab_id')->references('id')->on('labs')->onDelete('cascade');

            $table->foreignId('lab_branch_id')->nullable()->constrained('lab_branches')->onDelete('cascade');
            $table->foreignId('lab_category_id')->nullable()->constrained('lab_categories')->onDelete('cascade');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('reservations');
    }
};
