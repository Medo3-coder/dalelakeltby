<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalAdviceTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Factory::create('ar_SA');

        $data   = [];
        $images = [];
        for ($i = 0; $i < 200; $i++) {
            $data[] = [
                'title'       => json_encode(['ar' => $faker->name, 'en' => $faker->name]),
                'description' => json_encode(['ar' => $faker->realText, 'en' => $faker->realText]),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ];
            $images[] = [
                'image'             => null,
                'medical_advice_id' => $i + 1,
            ];
            $images[] = [
                'image'             => null,
                'medical_advice_id' => $i + 1,
            ];
            $images[] = [
                'image'             => null,
                'medical_advice_id' => $i + 1,
            ];
        }
        DB::table('medical_advice')->insert($data);
        DB::table('medical_advice_images')->insert($images);
    }
}
