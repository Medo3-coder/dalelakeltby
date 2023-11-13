<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ReservationImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = ['file', 'image'];
        $faker = Faker::create('ar_SA');
        $reservationImages = [];
        for ($i = 0; $i < 10; $i++) {
          $reservationImages [] = [
            'image'              => 'reservation.png',
            'reservation_id'     =>  rand(1 , 10),
            'type'               =>  'image',
          ];
        }
    
        DB::table('reservation_images')->insert($reservationImages) ; 
      }
    
}
