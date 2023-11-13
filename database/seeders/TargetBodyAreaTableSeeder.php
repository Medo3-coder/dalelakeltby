<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TargetBodyAreaTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker             = Faker::create('ar_SA');
        $target_body_areas = [];
        for ($i = 0; $i < 20; $i++) {
            $target_body_areas[] = [
                'name' => json_encode(['ar' => $faker->name, 'en' => $faker->name, 'kur' => $faker->name], JSON_UNESCAPED_UNICODE),
            ];
        }

        DB::table('target_body_areas')->insert($target_body_areas);
    }
}
