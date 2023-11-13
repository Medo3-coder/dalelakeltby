<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreBranchImagesTableSeeder extends Seeder
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
                'image'                     =>  '',
                'created_at'                =>  Carbon::now(),
                'updated_at'                =>  Carbon::now(),
            ];
        }


        DB::table('store_branch_images')->insert($branchTiming);
    }
}
