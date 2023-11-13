<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderRulesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'name' => json_encode(['ar' => 'قبول ورفض حجوزات', 'en' => 'Acceptance and rejection of reservations', 'kur' => 'قبوڵکردن و ڕەتکردنەوەی حجزکردن']),
                'type' => 'doctor',
            ],
            [
                'name' => json_encode(['ar' => 'اضافة ادوية', 'en' => 'Adding medicines', 'kur' => 'زیادکردنی دەرمان']),
                'type' => 'doctor',
            ],
            [
                'name' => json_encode(['ar' => 'اضافة تشخيص', 'en' => 'Add a diagnosis', 'kur' => 'دەستنیشانکردنێک زیاد بکە']),
                'type' => 'doctor',
            ],
        ];
        DB::table('provider_rules')->insert($data);
    }
}
