<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StoreBranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

      
        $faker = Faker::create('ar_SA');
        $labs = [];
        for ($i = 1; $i < 20; $i++) {

          $labs [] = [
            'store_id'                      =>  $i,
            'name'                          =>  $faker->name,
            'address'                       =>  $faker->streetAddress,
            'address_map'                   =>  'مدينة طلخا، مركز طلخا، الدقهلية 7623015، مصر',
            'lat'                           =>  '31.060925578043086',
            'lng'                           =>  '31.37170898437505',
            'opening_certificate_image'     =>  'default.png',
            'opening_certificate_pdf'       =>  'default.png',
            'comerical_record'              =>  rand(100000000000000000,10000000000000000),
            'created_at'                    =>  Carbon::now(),
            'updated_at'                    =>  Carbon::now(),
          ];
        }
    
        DB::table('store_branches')->insert($labs) ; 
      }
}
