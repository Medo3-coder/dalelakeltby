<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder {

    public function run() {

        $genders = ['male', 'female'];
        $age     = rand(1900, 2023);
        $faker   = Faker::create('ar_SA');
        $users   = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                'name'          => $faker->name,
                'phone'         => "51111111$i",
                'email'         => $faker->unique()->email,
                'password'      => Hash::make(123456),
                'is_blocked'    => 0,
                'code_expire'   => Carbon::now()->format('Y-m-d H:i:s'),
                'image'         => 'default.png',
                'age'           => $age,
                'lat'           => '31.0437192',
                'lng'           => '31.3880374',
                'has_diseases'  => rand(0, 1),
                'active'        => 1,
                'weight'        => rand(60, 130),
                'height'        => rand(150, 200),
                'gender'        => $genders[rand(0, 1)],
                'is_approved'   => 1,
                'blood_type_id' => rand(1, 5),

            ];
        }

        DB::table('users')->insert($users);
    }
}
