<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PharmacyTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker    = Faker::create('ar_SA');
        $pharmacy = [];
        for ($i = 0; $i < 20; $i++) {
            $pharmacy[] = [
                'name'        => $faker->name,
                'phone'       => "51111111" . $i,
                'password'    => Hash::make(123456),
                'email'       => $faker->unique()->email,
                'image'       => 'pharmacy.jpg',
                'lat'         => '31.0437192',
                'lng'         => '31.3873078',
                'is_blocked'  => 0,
                'is_active'   => 1,
                'is_approved' => 'accepted',
            ];
        }

        DB::table('pharmacies')->insert($pharmacy);
    }
}
