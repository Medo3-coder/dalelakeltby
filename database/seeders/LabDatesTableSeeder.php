<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LabDatesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Faker::create('ar_SA');
    $branchTiming = [];
    for ($i = 0; $i < 200; $i++) {
      $branchTiming[] = [
        'lab_id'         => ($i % 10) + 1,
        'lab_branch_id'        => ($i % 40) + 1,
        'day'        => $faker->dayOfWeek,
        'from'     => $faker->unique()->time(),
        'to'      => $faker->unique()->time(),
      ];
    }
    DB::table('lab_branch_dates')->insert($branchTiming);
  }
}
