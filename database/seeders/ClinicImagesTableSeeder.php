<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicImagesTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {


        $images        = [];
        for ($i = 0; $i < 300; $i++) {
            $images[] = [
                'image'     => 'clinics.png',
                'clinic_id' => ($i % 60) + 1,
            ];
        }

        DB::table('clinic_images')->insert($images);
        

    }
}
