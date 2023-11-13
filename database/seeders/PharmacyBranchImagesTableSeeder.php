<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PharmacyBranchImagesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $faker = Faker::create('ar_SA');

        DB::table('pharmacy_branch_images')->insert([
            [
                'image'              => 'clinics.png',
                'pharmacy_branch_id' => 1,

            ],
            [
                'image'              => 'clinics.png',
                'pharmacy_branch_id' => 2,
            ],
            [
                'image'              => 'clinics.png',
                'pharmacy_branch_id' => 3,
            ],
            [
                'image'              => 'clinics.png',
                'pharmacy_branch_id' => 4,
            ],

            [
                'image'              => 'clinics.png',
                'pharmacy_branch_id' => 5,
            ],

            // [
            //   'image'         => 'clinics.png',

            //   'pharmacy_branch_id'        => 7
            // ],

        ]);

    }
}
