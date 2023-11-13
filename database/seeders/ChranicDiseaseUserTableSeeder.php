<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ChranicDiseaseUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ar_SA');
        // 1
        DB::table('chranic_disease_users')->insert([
            [
                'user_id'                        => 1 , 
                'chranic_disease_id'             =>  1,
                'created_at'        => Carbon::now()
            ],[
                'user_id'                        => 2 , 
                'chranic_disease_id'             =>  3,
                'created_at'        => Carbon::now()
            ],[
                'user_id'                        => 4 , 
                'chranic_disease_id'             =>  2,
                'created_at'        => Carbon::now()
            ],[
                'user_id'                        => 8 , 
                'chranic_disease_id'             =>  5,
                'created_at'        => Carbon::now()
            ],[
                'user_id'                        => 10 , 
                'chranic_disease_id'             =>  6,
                'created_at'        => Carbon::now()
            ]
            ,[
                'user_id'                        => 9 , 
                'chranic_disease_id'             =>  2,
                'created_at'        => Carbon::now()
            ]
            ,[
                'user_id'                        => 3 , 
                'chranic_disease_id'             =>  4,
                'created_at'        => Carbon::now()
            ]
        ]);
    

    }
}
