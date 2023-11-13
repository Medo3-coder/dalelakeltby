<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfferSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker::create('ar_SA');
        for ($i = 1; $i < 20; $i++) {

            $languages = [];

            foreach (languages() as $lang) {
                $languages[$lang] = $faker->name;
            }

            $type = ['products', 'equipment'];

            for ($a = 2; $a >= 0; $a--) {
                $rows[] = [
                    'store_id'          => $i,
                    'name'              => json_encode($languages),
                    'offer_price'       => $faker->numberBetween(100, 1000),
                    'offer_discount'    => $faker->numberBetween(10, 100),
                    'bonus'             => $faker->numberBetween(100, 1000),
                    'type'              => $type[rand(0, 1)],
                    'end_offer'         => Carbon::now()->addMonth(),
                    'offer_num'         => Carbon::now()->format('Y') . $i . rand(1, 999999) . $a,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),

                ];

                $products[] = [
                    'product_id'        => $i,
                    'store_id'          => $i,
                    'offer_id'          => $i * 3 - $a,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now(),

                ];
            }

        }

        DB::table('offers')->insert($rows);
        DB::table('offer_products')->insert($products);
    }
}
