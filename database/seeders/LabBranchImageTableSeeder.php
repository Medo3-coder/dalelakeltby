<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LabBranchImageTableSeeder extends Seeder
{
    public function run() {
      $faker = Faker::create('ar_SA');
      $labs = [];
      for ($i = 0; $i < 20; $i++) {
        $labs [] = [
          'image'         => 'Labbrnach.png',
          'lab_id'         => $faker->longitude(),
          'lab_branch_id'        =>$faker->latitude(),
        ];
      }
      DB::table('lab_branch_images')->insert($labs) ; 
    }
}
