<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacyDateTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create('ar_SA');

        $pharmacyDate = [];
        for ($i = 0; $i < 120; $i++) {
            $pharmacyDate[] = [
                'pharmacy_branch_id' => ($i % 40) + 1,
                'day'                => $faker->dayOfWeek,
                'from'               => $faker->unique()->time(),
                'to'                 => $faker->unique()->time(),
            ];
        }

        DB::table('pharmacy_dates')->insert($pharmacyDate);
    }
}
