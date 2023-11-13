<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CancelReasonTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('cancel_reasons')->insert([
            ['reason' => json_encode(['ar' => 'سبب الالغاء1', 'en' => 'cancel reason 1', 'kur' => 'cancel reason 1'])],
            ['reason' => json_encode(['ar' => 'سبب الالغاء2', 'en' => 'cancel reason 2', 'kur' => 'cancel reason 2'])],
            ['reason' => json_encode(['ar' => 'سبب الالغاء3', 'en' => 'cancel reason 3', 'kur' => 'cancel reason 3'])],
            ['reason' => json_encode(['ar' => 'سبب الالغاء4', 'en' => 'cancel reason 4', 'kur' => 'cancel reason 4'])],
            ['reason' => json_encode(['ar' => 'سبب الالغاء5', 'en' => 'cancel reason 5', 'kur' => 'cancel reason 5'])],
        ]);
    }
}
