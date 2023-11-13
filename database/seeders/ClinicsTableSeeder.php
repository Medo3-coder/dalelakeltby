<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $faker = Faker::create('ar_SA');

        $clinics        = [];
        for ($i = 0; $i < 60; $i++) {
            $clinics[] = [
                'lat'              => '31.' . rand(1000 ,999999),
                'lng'              => '31.' . rand(1000 ,999999),
                'name'             => $faker->name,
                'address'          => $faker->address,
                'comerical_record' => rand(2, 20),
                'detection_price'  => rand(50, 100),
                'doctor_id'        => ($i % 20) + 1,
                'created_at'       => Carbon::now(),
            ];
        }

          DB::table('clinics')->insert($clinics);

//        DB::table('clinics')->insert([
//            [
//                'lat'              => '31.0437192',
//                'lng'              => '31.3873078',
//                'name'             => $faker->name,
//                'address'          => $faker->address,
//                'comerical_record' => rand(2, 20),
//                'detection_price'  => rand(50, 100),
//                'doctor_id'        => 1,
//                'created_at'       => Carbon::now(),
//            ], [
//                'lat'              => '31.0437192',
//                'lng'              => '31.3873078',
//                'name'             => $faker->name,
//                'address'          => $faker->address,
//                'comerical_record' => rand(2, 20),
//                'detection_price'  => rand(50, 100),
//                'doctor_id'        => 2,
//                'created_at'       => Carbon::now(),
//            ], [
//                'lat'              => '31.0437192',
//                'lng'              => '31.3873078',
//                'name'             => $faker->name,
//                'address'          => $faker->address,
//                'comerical_record' => rand(2, 20),
//                'detection_price'  => rand(50, 100),
//                'doctor_id'        => 3,
//                'created_at'       => Carbon::now(),
//            ], [
//                'lat'              => '31.0437192',
//                'lng'              => '31.3873078',
//                'name'             => $faker->name,
//                'address'          => $faker->address,
//                'comerical_record' => rand(2, 20),
//                'detection_price'  => rand(50, 100),
//                'doctor_id'        => 4,
//                'created_at'       => Carbon::now(),
//            ], [
//                'lat'              => '31.0437192',
//                'lng'              => '31.3873078',
//                'name'             => $faker->name,
//                'address'          => $faker->address,
//                'comerical_record' => rand(2, 20),
//                'detection_price'  => rand(50, 100),
//                'doctor_id'        => 5,
//                'created_at'       => Carbon::now(),
//            ], [
//                'lat'              => '31.0437192',
//                'lng'              => '31.3873078',
//                'name'             => $faker->name,
//                'address'          => $faker->address,
//                'comerical_record' => rand(2, 20),
//                'detection_price'  => rand(50, 100),
//                'doctor_id'        => 6,
//                'created_at'       => Carbon::now(),
//            ], [
//                'lat'              => '31.0437192',
//                'lng'              => '31.3873078',
//                'name'             => $faker->name,
//                'address'          => $faker->address,
//                'comerical_record' => rand(2, 20),
//                'detection_price'  => rand(50, 100),
//                'doctor_id'        => 7,
//                'created_at'       => Carbon::now(),
//            ],
//        ]);

    }
}
