<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabCategoryTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // 1'name', 'has_targeted_body', 'parent_id'

        $faker = Factory::create('ar_SA');

        $labCategories = [
            [
                'name'              => json_encode(['en' => 'Sonar', 'ar' => 'السونار', 'kur' => 'سۆنار'], JSON_UNESCAPED_UNICODE),
                'has_targeted_body' => 1,
                'parent_id'         => null,
                'created_at'        => Carbon::now(),
            ], [
                'name'              => json_encode(['en' => 'Analytics', 'ar' => 'التحاليل', 'kur' => 'شیکارییەکان دەکات'], JSON_UNESCAPED_UNICODE),
                'has_targeted_body' => 0,
                'parent_id'         => null,
                'created_at'        => Carbon::now(),
            ], [
                'name'              => json_encode(['en' => 'Scan', 'ar' => 'الاشاعة', 'kur' => 'دەنگۆکە'], JSON_UNESCAPED_UNICODE),
                'has_targeted_body' => 1,
                'parent_id'         => null,
                'created_at'        => Carbon::now(),
            ],
        ];

        for ($i = 0; $i < 20; $i++) {
            $labCategories[] = [
                'name'              => json_encode(['en' => $faker->name, 'ar' => 'فرعي '.$faker->name, 'kur' => $faker->name], JSON_UNESCAPED_UNICODE),
                'has_targeted_body' => 0,
                'parent_id'         => rand(1, 3),
                'created_at'        => Carbon::now(),
            ];
        }
        DB::table('lab_categories')->insert($labCategories);

    }
}
