<?php

namespace Database\Seeders;

use App\Models\ChranicDiseases;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ChranicDiseasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();
        foreach (range(1,3) as $index) {
            DB::table('chranic_diseases')->insert([
                [
                    'name'              => json_encode(['en' => 'cancer', 'ar' => 'السرطان', 'kur' => 'qansêr'] , JSON_UNESCAPED_UNICODE),
          
                ],
                [
                    'name'              => json_encode(['en' => 'skin cancer', 'ar' => 'سرطان الجلد', 'kur' => 'kansera çerm'] , JSON_UNESCAPED_UNICODE),
                ],
                [
                    'name'              => json_encode(['en' => 'diabetes', 'ar' => 'السكري', 'kur' => 'nexweşîya şekir'] , JSON_UNESCAPED_UNICODE),
                ],
                [
                    'name'              => json_encode(['en' => 'arthritis', 'ar' => 'التهاب المفاصل ', 'kur' => 'birîna mofirkan'] , JSON_UNESCAPED_UNICODE),
                ],

                [
                    'name'              => json_encode(['en' => 'Obesity', 'ar' => 'بدانة', 'kur' => 'qelewbûn'] , JSON_UNESCAPED_UNICODE),
                ],

                [
                    'name'              =>json_encode(['en' => 'Epilepsy', 'ar' => 'الصرع ', 'kur' => 'Epîlepsî'] , JSON_UNESCAPED_UNICODE),
                ],


            ]);
        }
    }
}
