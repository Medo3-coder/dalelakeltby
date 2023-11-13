<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Properity;

class ProperitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $properities =  json_decode(file_get_contents(__DIR__ . '/data/properities/main.json'), true);

        foreach ($properities as $peoperity) {
            Properity::create([
                'feature_id'                    => $peoperity['feature_id'],
                'name'                          => $peoperity['name']
            ]);
        }
        // feautre 2 properties
        Properity::create([
            'feature_id'                    => 2,
            // json_encode(['ar' =>  $faker->name , 'en' =>  $faker->name ,  'kur' =>  $faker->name], JSON_UNESCAPED_UNICODE)
            'name'                          => ['ar' => 'احمر' , 'en' => 'Red' , 'kur' => 'سوور'] ,
        ]);
        Properity::create([
            'feature_id'                    => 2,
            'name'                          => ['ar' => 'ابيض' , 'en' => 'white' , 'kur' => 'سپی']  ,
        ]);
        Properity::create([
            'feature_id'                    => 2,
            'name'                          => ['ar' => 'اخضر' , 'en' => 'green' , 'kur' => 'سەوز']  ,
        ]);
        Properity::create([
            'feature_id'                    => 2,
            'name'                          => ['ar' => 'اصفر' , 'en' => 'yellow' , 'kur'=> 'زەرد'] ,
        ]);
        Properity::create([
            'feature_id'                    => 2,
            'name'                          => ['ar' => 'اسود' , 'en' => 'black' , 'kur' => 'ڕەش'] ,
        ]);
        // feautre 2 properties

        // feautre 3 properties, JSON_UNESCAPED_UNICODE) ,
        Properity::create([
            'feature_id'                    => 3,
            'name'                          => ['ar' => 'جبردين' , 'en' => 'Red'  , 'kur' => 'سوور'] ,
        ]);
        Properity::create([
            'feature_id'                    => 3,
            'name'                          => ['ar' => 'ميلتون' , 'en' => 'white' , 'kur' => 'سپی']  ,
        ]);
        Properity::create([
            'feature_id'                    => 3,
            'name'                          => ['ar' => 'جينز' , 'en' => 'green' , 'kur' => 'سەوز'] ,
        ]);
        // feautre 3 properties

    }
}
