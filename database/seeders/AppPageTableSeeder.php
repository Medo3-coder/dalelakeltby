<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_pages')->insert([
            ['image' => '1.png'],
            ['image' => '2.png'],
            ['image' => '3.png'],
            ['image' => '4.png'],
            ['image' => '5.png'],
        ]);
    }
}
