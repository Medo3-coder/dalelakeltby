<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacyBranchesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $faker = Faker::create('ar_SA');

        $pharmacyBranch = [];
        for ($i = 0; $i < 40; $i++) {
            $pharmacyBranch[] = [
                'pharmacist_id'    => ($i % 20) + 1,
                'address'          => $faker->address,
                'name'             => $faker->name,
                'comerical_record' => rand(1, 10),
                'lat'              => '31.' . rand(10000, 9999999),
                'lng'              => '31.' . rand(10000, 9999999),
            ];
        }

        DB::table('pharmacy_branches')->insert($pharmacyBranch);
    }
}
