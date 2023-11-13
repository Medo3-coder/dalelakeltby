<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

      
        $faker = Faker::create('ar_SA');
        $type = ['equipment','medicine'];
        $product_categories = [];
        for ($i = 0; $i < 10; $i++) {
          $labs [] = [
            'name'         => $faker->name,
            'type'         => $type[rand(0 , 1)]
        
          ];
        }
    
        DB::table('product_categories')->insert($labs) ; 
      }
}
