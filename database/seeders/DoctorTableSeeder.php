<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorTableSeeder extends Seeder {

    public function run() {

        $status  = ['pending', 'accepted', 'rejected'];
        $faker   = Faker::create('ar_SA');
        $doctors = [];
        for ($i = 0; $i < 20; $i++) {
            $doctors[] = [
                'name'                           => $faker->name,
                'nickname'                       => $faker->name,
                'address'                        => $faker->address,
                'qualifications'                 => $faker->realText,
                'abstract'                       => $faker->realText,
                'age'                            => rand(1900, 2023),
                'phone'                          => "51111111$i",
                'email'                          => $faker->unique()->email,
                'identity_number'                => rand(1, 14),
                'identity_image'                 => 'identity.png',
                'graduation_certification_image' => 'graduation.jpg',
                'graduation_certification_pdf'   => 'graduation.pdf',
                'practice_certification_image'   => 'practice.jpg',
                'practice_certification_pdf'     => 'practice.pdf',
                'experience_certification_image' => 'experience.jpg',
                'experience_certification_pdf'   => 'experience.pdf',
                'experience_years'               => rand(0, 30),
                'password'                       => Hash::make(123456),
                'is_blocked'                     => 0,
                'image'                          => 'doctor.jpg',
                'is_active'                      => 1,
                'average_rate'                   => rand(1.2, 4.9),
                'count_rate'                     => rand(1, 100),
                'city_id'                        => rand(1, 50),
                'is_approved'                    => 'accepted',
                'category_id'                    => rand(1, 15),
            ];
        }

        DB::table('doctors')->insert($doctors);
    }
}