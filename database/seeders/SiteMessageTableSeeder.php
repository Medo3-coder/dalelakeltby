<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteMessageTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('site_messages')->insert([
            [
                'name'         => 'احمد مصطفي',
                'country_code' => "+20",
                'phone'        => "01023423423",
                'message'      => "الرسالة",
            ],
        ]);
    }
}
