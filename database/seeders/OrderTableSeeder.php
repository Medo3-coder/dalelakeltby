<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Order;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ar_SA');
        $payment_status =  ['pending', 'paid'];
        $payment_type = ['installment', 'cash', 'online'];
        $Receiving_method = ['by_delegate', 'on_arrival'];
        // $product_type = ['medicine' ,'tools'];
        $status = ['pending', 'accepted', 'prepared', 'rejected' , 'canceled'];
        //store status // ناقصة    
        $orders = [];  
        for ($i = 1; $i < 20; $i++) {
            $orders [] = 
            [
                'store_id'                     =>  rand(1, 10),
                'pharmacist_id'                =>  rand(1, 10),
                'pharmacy_branch_id'                  => rand(1, 6),
                'payment_type'                 =>  $payment_type[rand(0, 2)],
                'payment_status'               => $payment_status[rand(0,1)],
                'Receiving_method'             =>  $Receiving_method[rand(0, 1)],
                'status'                       =>  $status[rand(0, 3)],
                'deliver_lat'                  =>   $faker->latitude(),
                'deliver_lng'                  => $faker->longitude(),
                'address'                      =>  $faker->address,
                'deliver_date'                 =>   $faker->unique()->date(),
                'prepare_time'                 =>  $faker->unique()->time(),
                'vat_amount'                   =>  rand(10, 60),
                'vat_ratio'                    =>  rand(1, 5),
                'final_total'                  =>  rand(50, 1000),
                'total_price'                        =>  rand(50, 700),
                'delivery_price'               =>  rand(130, 600),
                'coupon'                       =>   Str::random(10),
                'admin_commission_ratio'       =>  rand(10, 20),
                'admin_commission_amount'      =>  rand(7, 25),
                'notes'                        => $faker->realText,
                'order_num'                     =>  Carbon::now()->format('Y') . $i,
                'created_at'                    =>  Carbon::now(),
                'updated_at'                    =>  Carbon::now(),

            ];
        }
        DB::table('orders')->insert($orders) ; 
    }
}
