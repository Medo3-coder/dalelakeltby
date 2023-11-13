<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LabTableSeeder extends Seeder {
    public function run() {
        $faker       = Faker::create('ar_SA');
        $labs        = [];
        $labCategory = Category::where('type', 'lab')->first();
        for ($i = 0; $i < 10; $i++) {
            $labs[] = [
                'name'           => $faker->name,
                'address'        => $faker->address,
                'phone'          => "51111111$i",
                'password'       => Hash::make(123456),
                'email'          => $faker->unique()->email,
                'image'          => 'lab.jpg',
                'identity_id'    => rand(2, 20),
                'identity_image' => 'identity.png',
                'lab_name'       => $faker->name,
                'is_blocked'     => 0,
                'is_approved'    => 'accepted',
                'is_active'      => 1,
                'rate_avg'       => rand(0, 5),
                'category_id'    => $labCategory->id,
                'city_id'        => rand(1, 10),
            ];
        }
        DB::table('labs')->insert($labs);
    }
}
