<?php

namespace Database\Seeders;

use App\Models\BloodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BloodTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
            BloodType::insert([
                ['name' => 'AB+'],
                ['name' => 'O'],	
                ['name' => 'A−'],
                ['name' => 'O−'],
                ['name' => 'A'],
                ['name' => 'B'],
                ['name' => 'B+']

            ]);
        }
   
}
