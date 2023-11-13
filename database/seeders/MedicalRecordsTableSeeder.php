<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class MedicalRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   
        $faker = Faker::create('ar_SA');
        $MedicalRecords = [];
        for ($i = 0; $i < 3; $i++) {
            $MedicalRecords[] = [
                'diagnosis'              => $faker->realText,
                'reservation_id'        =>  rand(1, 10),
                'ragite_id'           =>  rand(1, 10),
                'chranic_disease_id'        =>  rand(1, 3),


            ];
        }

        DB::table('medical_records')->insert($MedicalRecords);
    }
}
