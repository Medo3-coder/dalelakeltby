<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreCouponsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ar_SA');
        $branchTiming = [];
        $type = ['ratio', 'number'];
        for ($i = 1; $i < 20; $i++) {
            $branchTiming[] = [
                'store_id'                  =>  $i,
                'code'                      =>  $faker->lexify(),
                'type'                      =>  $type[rand(0,1)],
                'discount'                  =>  $faker->numberBetween(10,100),
                'max_discount'              =>  $faker->numberBetween(10, 1000),
                'expire_date'               =>  Carbon::now()->addMonth(),
                'max_use'                   =>  $faker->numberBetween(20, 150),
                'created_at'                =>  Carbon::now(),
                'updated_at'                =>  Carbon::now(),
            ];
        }


        DB::table('store_coupons')->insert($branchTiming);
    }
}
