<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class RagitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   
        $faker = Faker::create('ar_SA');
        $Ragites = [];
        for ($i = 0; $i < 10; $i++) {
          $Ragites [] = [
            'image'              => 'ragites.png',
            'doctor_id'        => rand(1,10),
          ];
        }
    
        DB::table('ragites')->insert($Ragites) ; 
      }
    
}
