<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorePermitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker  = Faker::create('ar_SA');
        $stores = [];

        for ($i = 1; $i < 20; $i++) {

            $stores[] = [
                'store_id'                  =>  $i,
                'name'                      =>  $faker->name,
                'image'                     =>  '',
                'file'                      =>  '',
                'created_at'                =>  Carbon::now(),
                'updated_at'                =>  Carbon::now(),
            ];
        }

        DB::table('store_permits')->insert($stores);
    }
}
