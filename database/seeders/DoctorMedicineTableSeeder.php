<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DoctorMedicineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

       
      
        $faker = Faker::create('ar_SA');
        $doctor_medicines = [];
        for ($i = 0; $i < 80; $i++) {
          $doctor_medicines [] = [
            'doctor_id'         =>  ($i % 20) + 1,
            'name'        => $faker->name,
            'type'        =>  $faker->realText,
          ];
        }
    
        DB::table('doctor_medicines')->insert($doctor_medicines) ; 
      }
}
