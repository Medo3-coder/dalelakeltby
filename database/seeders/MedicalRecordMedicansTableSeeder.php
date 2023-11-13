<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MedicalRecordMedicansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

      
        $faker = Faker::create('ar_SA');
        $labs = [];
        for ($i = 0; $i < 10; $i++) {
          $medicalRecordMedicans [] = [
            'medical_record_id'         => rand(1,3),
            'doctor_medican_id'        =>rand(1,10),
            'hours'        =>   rand(1 , 24),
            'times'        => rand(1,10),
            'reservation_id'      => rand(1,20),

          ];
        }
    
        DB::table('medical_record_medicans')->insert($medicalRecordMedicans) ; 
      }
}
