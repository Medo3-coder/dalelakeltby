<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PharmacistTableSeeder extends Seeder {

    public function run() {
        $faker       = Faker::create('ar_SA');
        $pharmacists = [];
        for ($i = 0; $i < 20; $i++) {
            $pharmacists[] = [
                'name'            => $faker->name,
                'phone'           => "51111111" . $i,
                'identity_number' => "51111111" . $i,
                'experience_years' => $i % 10,
                'identity_image' => "aaa.png",
                'age'             => rand(25, 40),
                'password'        => Hash::make(123456),
                'email'           => $faker->unique()->email,
                'image'           => 'pharmacists.jpg',
                'is_blocked'      => 0,
                'is_active'       => 1,
                'is_approved'     => 'accepted',
            ];
        }

        DB::table('pharmacists')->insert($pharmacists);
    }
}
