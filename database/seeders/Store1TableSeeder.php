<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Store1TableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $faker  = Faker::create('ar_SA');
        $stores = [];
        for ($i = 1; $i < 20; $i++) {

            $stores[] = [
                'id'                    =>  $i,
                'name'                  =>  $faker->name,
                'phone'                 =>  "123456789$i",
                'password'              =>  Hash::make(123456),
                'email'                 =>  $faker->unique()->email,
                'image'                 =>  '',
                'country_code'          =>  '966',
                'identity_number'       =>  rand(100000000000000000,10000000000000000),
                'identity_image'        =>  'default.png',
                'is_active'             =>  1,
                'is_approved'           =>  'accepted',
                'created_at'            =>  Carbon::now(),
                'updated_at'            =>  Carbon::now(),
                'delivery_price'        =>  $faker->numberBetween(10, 100)
            ];
        }

        DB::table('stores')->insert($stores);
    }
}
