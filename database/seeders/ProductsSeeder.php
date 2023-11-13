<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
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
            $category_type              = ['equipment', 'medicine'];
            $type                       = ['simple', 'multiple'];
            $available                  = ['true', 'false'];
            $properities                = [null, '[1]', '[1,2]', '[1,2,3]'];
            $in_stock_type              = ['in', 'out'];

            $rows [] = [
                'id'                    =>  $i,
                'product_num'           =>  Carbon::now()->format('Y') . $i,
                'store_id'              =>  $i,
                'name'                  =>  json_encode($languages) ,
                'type'                  =>  $type[rand(0, 1)] ,
                'available'             =>  $available[rand(0, 1)] ,
                'desc'                  =>  json_encode($languages) ,
                'category_type'         =>  $category_type[rand(0,1)] ,
                'date_of_supply'        =>  Carbon::now(),
                'effective_material'    =>  $faker->name,
                'created_at'            =>  Carbon::now(),
                'updated_at'            =>  Carbon::now(),

            ];

            $images [] = [
                'product_id'            =>  $i ,
                'created_at'            =>  Carbon::now(),
                'updated_at'            =>  Carbon::now(),
            ];

            $groups [] = [
                'product_id'            =>  $i ,
                'properities'           =>  $properities[rand(0,3)],
                'desc'                  =>  json_encode($languages),
                'price'                 =>  $faker->numberBetween(100,10000),
                'in_stock_type'         =>  $in_stock_type[rand(0,1)],
                'in_stock_qty'          =>  $faker->numberBetween(10,150),
                'in_stock_sku'          =>  $faker->name,
                'created_at'            =>  Carbon::now(),
                'updated_at'            =>  Carbon::now(),
            ];
        }



        DB::table('products')->insert($rows) ;
        DB::table('product_images')->insert($images) ;
        DB::table('product_groups')->insert($groups) ;
    }
}
