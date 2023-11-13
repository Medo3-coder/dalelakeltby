<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker          = Faker::create('ar_SA');
        $reservationFor = ['same_person', 'family'];
        $status         = ['new', 'approved', 'on_progress', 'transfer_to_lab', 'lab_send_results', 'finished', 'rejected'];
        $payment_status = ['pending', 'paid'];
        $reservation    = [];
        for ($i = 0; $i < 30; $i++) {

            $reservation[] = [
                'user_id'                 => rand(1, 10),
                'doctor_id'               => rand(1, 10),
                'clinic_id'               => rand(1, 7),
                'lat'                     => '31.0437192',
                'lng'                     => '31.3873078',
                'reservation_for'         => $reservationFor[rand(0, 1)],
                'date'                    => Carbon::now()->addDays(rand(1, 10))->format('Y-m-d H:i:s'),
                'time'                    => Carbon::now()->format('H:i:s'),
                'details'                 => $faker->realText,
                'reservation_price'       => rand(20, 600),
                'detection_price'         => rand(20, 200),
                'admin_commission_ratio'  => rand(10, 50),
                'admin_commission_amount' => rand(10, 90),
                'vat_rate_ratio'          => rand(0, 40),
                'vat_rate_amount'         => rand(10, 60),
                'total_price'             => rand(100, 600),
                'final_total'             => rand(190, 900),
                'paient_name'             => $faker->name,
                'paient_blood_type_id'    => rand(1, 5),
                'paient_age'              => rand(15, 70),
                'paient_weight'           => rand(60, 160),
                'paient_height'           => rand(160, 210),
                'status'                  => $status[rand(0, 3)],
                'rate'                    => rand(0, 5),
                'payment_status'          => $payment_status[rand(0, 1)],
                'payment_method'          => 'wallet',
                'comment'                 => $faker->realText,
                'created_at'              => Carbon::now(),
                //  'lab_branch_id'
            ];
        }

        DB::table('reservations')->insert($reservation);
    }
}
