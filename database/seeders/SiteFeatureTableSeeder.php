<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteFeatureTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('site_features')->insert([
            [
                'title'       => json_encode(['ar' => 'سهولة البحث', 'en' => 'سهولة البحث', 'kur' => 'سهولة البحث']),
                'description' => json_encode(['ar' => ' سهولة البحث سهولة البحث سهولة البحث', 'en' => ' سهولة البحث سهولة البحث سهولة البحث', 'kur' => ' سهولة البحث سهولة البحث سهولة البحث']),
            ],
            [
                'title'       => json_encode(['ar' => 'سهولة الوصول', 'en' => 'سهولة الوصول', 'kur' => 'سهولة الوصول']),
                'description' => json_encode(['ar' => ' سهولة الوصول سهولة الوصول سهولة الوصول', 'en' => ' سهولة الوصول سهولة الوصول سهولة الوصول', 'kur' => ' سهولة الوصول سهولة الوصول سهولة الوصول']),
            ],

            [
                'title'       => json_encode(['ar' => 'دفع بسهولة', 'en' => 'دفع بسهولة', 'kur' => 'دفع بسهولة']),
                'description' => json_encode(['ar' => ' دفع بسهولة دفع بسهولة دفع بسهولة', 'en' => ' دفع بسهولة دفع بسهولة دفع بسهولة', 'kur' => ' دفع بسهولة دفع بسهولة دفع بسهولة']),
            ],
            [
                'title'       => json_encode(['ar' => 'دعم طوال اليوم', 'en' => 'دعم طوال اليوم', 'kur' => 'دعم طوال اليوم']),
                'description' => json_encode(['ar' => ' دعم طوال اليوم دعم طوال اليوم دعم طوال اليوم', 'en' => ' دعم طوال اليوم دعم طوال اليوم دعم طوال اليوم', 'kur' => ' دعم طوال اليوم دعم طوال اليوم دعم طوال اليوم']),
            ],
        ]);
    }
}
