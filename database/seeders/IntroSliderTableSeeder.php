<?php
namespace Database\Seeders;

use App\Models\IntroSlider;
use Illuminate\Database\Seeder;
use DB;

class IntroSliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('intro_sliders')->insert([
            [
                'image'       => '1.png' ,
                'title'       => json_encode(['ar' => 'عنوان البانر الاول', 'en' => 'First banner title ' , 'kur' => 'Sernavê pankarta yekem' ], JSON_UNESCAPED_UNICODE) ,
                'description' => json_encode(['ar' => ' وسف البانر الاول' , 'en' => 'first banner description', 'kur' => 'danasîna pankarta yekem' ], JSON_UNESCAPED_UNICODE) ,
            ] ,[
                'image'       => '2.png' ,
                'title'       => json_encode(['ar' => 'عنوان البانر الثاني', 'en' => 'secound banner title ' , 'kur' => 'sernavê pankarta duyemîn '  ], JSON_UNESCAPED_UNICODE) ,
                'description' => json_encode(['ar' => ' وسف البانر الثاني' , 'en' => 'secound banner description'  , 'kur' => 'danasîna pankarta yekem'], JSON_UNESCAPED_UNICODE) ,
            ],[
                'image'       => '1.png' ,
                'title'       => json_encode(['ar' => 'عنوان البانر الثالث', 'en' => 'third banner title ' , 'kur' => 'sernavê pankarta duyemîn ' ], JSON_UNESCAPED_UNICODE) ,
                'description' => json_encode(['ar' => ' وسف البانر الثالث' , 'en' => 'third banner description'  , 'kur' => 'danasîna pankarta yekem' ], JSON_UNESCAPED_UNICODE ),
            ],[
                'image'       => '2.png' ,
                'title'       => json_encode(['ar' => 'عنوان البانر الرابع', 'en' => 'fourth banner title ' ,  'kur' => 'sernaê pankarta duyemîn ' ], JSON_UNESCAPED_UNICODE) ,
                'description' => json_encode(['ar' => ' وسف البانر الرابع' , 'en' => 'fourth banner description' ,  'kur' => 'danasîna pankarta yekem' ], JSON_UNESCAPED_UNICODE) ,
            ]
        ]);
       
    }
}
