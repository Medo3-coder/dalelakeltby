<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ClinicDatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
         $faker = Faker::create('ar_SA');


        $ClinicDates = [];
        for ($i = 0; $i < 300; $i++) {
          $ClinicDates [] = [
            'clinic_id'         => ($i % 60) + 1,
            'day'        => $faker->dayOfWeek,
            'from'     => $faker->unique()->time(),
            'to'      => $faker->unique()->time(),
          ];
        }


        DB::table('clinic_dates')->insert($ClinicDates) ; 
    }
}
