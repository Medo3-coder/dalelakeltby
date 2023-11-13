<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrderProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = Faker::create('ar_SA');
  
        $order_products = [];
        for ($i = 0; $i < 2; $i++) {
            $order_products[] = [
                'order_id'         => rand(1, 9),
                'product_id'             => rand(1 , 2),
                'group_id'             => rand(1 , 4),
                'price'    =>  rand(1, 10),
                'qty'         =>  rand(1, 15),

            ];
        }

        DB::table('order_products')->insert($order_products);
    }
}
