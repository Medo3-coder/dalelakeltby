<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductAdditiveCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ar_SA');
        for ($i = 1; $i < 20; $i++) {

            $languages = [];

            foreach (languages() as $lang){
                $languages[$lang] = $faker->name;
            }

            $rows [] = [
                'store_id'                  =>  $i,
                'name'                      =>  json_encode($languages),
                'created_at'                =>  Carbon::now(),
                'updated_at'                =>  Carbon::now(),

            ];
        }

        DB::table('product_additive_categories')->insert($rows) ;
    }
}
