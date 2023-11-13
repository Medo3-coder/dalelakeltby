<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class StoreBranchDatesTableSeeder extends Seeder
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
    for ($i = 1; $i < 20; $i++) {
      $branchTiming[] = [
        'store_id'                  =>  $i,
        'store_branch_id'           =>  $i,
        'day'                       =>  strtolower($faker->dayOfWeek),
        'from'                      =>  $faker->unique()->time(),
        'to'                        =>  $faker->unique()->time(),
        'created_at'                =>  Carbon::now(),
        'updated_at'                =>  Carbon::now(),
      ];
    }


    DB::table('store_dates')->insert($branchTiming);
  }
}
