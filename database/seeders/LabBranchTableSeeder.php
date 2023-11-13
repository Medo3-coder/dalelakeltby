<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabBranchTableSeeder extends Seeder {
    public function run() {
        $faker = Faker::create('ar_SA');
        $labs  = [];
        for ($i = 0; $i < 40; $i++) {
            $labs[] = [
                'lab_id'                    => ($i % 10) + 1,
                'lat'                       => '31.' . rand(10000, 9999999),
                'lng'                       => '31.' . rand(10000, 9999999),
                'name'                      => $faker->name,
                'address'                   => $faker->address,
                'opening_certificate_image' => 'opening.jpg',
                'opening_certificate_pdf'   => 'opening.pdf',
                'comerical_record'          => rand(1, 10),
            ];
        }
        DB::table('lab_branches')->insert($labs);
        $iamges = [];
        for ($i = 0; $i < 200; $i++) {
            $iamges[] = [
                'lab_branch_id' => ($i % 40) + 1,
                'image'         => 'default.png',
            ];
        }
        DB::table('lab_branch_images')->insert($iamges);

    }
}
