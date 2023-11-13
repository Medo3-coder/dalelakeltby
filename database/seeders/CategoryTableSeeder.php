<?php
namespace Database\Seeders;



use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {     
            $faker = Faker::create('ar_SA');
            // 1
            DB::table('categories')->insert([
                [
                    'name'              => json_encode(['en' => 'esoteric'  , 'ar' => 'الباطنة'  ,'kur' => 'ezoterîk'] , JSON_UNESCAPED_UNICODE) , 
                    'image'             =>  "1.png",
                    'type'              => 'doctor', 
                    'created_at'        => Carbon::now()
                ],[
                    'name'              => json_encode(['en' => 'bones'  , 'ar' => 'العظام' , 'kur' => 'hestî'] , JSON_UNESCAPED_UNICODE) , 
                    'image'             => "2.png",
                    'type'              => 'doctor', 
                    'created_at'        => Carbon::now()
                ],[
                    'name'              => json_encode(['en' => 'nose ear and throat'  , 'ar' => 'انفم واذن وحنجرة' , 'kur' => 'guh û qirik poz'] , JSON_UNESCAPED_UNICODE) , 
                    'image'              => "3.png",
                    'type'              => 'doctor', 
                    'created_at'        => Carbon::now()
                ],[
                    'name'              => json_encode(['en' => 'obstetrics and gynecology'  , 'ar' => 'نساء وتوليد' , 'kur' => 'zayin û jineolojî'] , JSON_UNESCAPED_UNICODE) , 
                    'image'              =>  "4.jpg",
                    'type'              => 'doctor', 
                    'created_at'        => Carbon::now()
                ],[
                    'name'              => json_encode(['en' => 'Psychiatry'  , 'ar' => 'الطب النفسي' , 'kur' => 'Psychiatry'] , JSON_UNESCAPED_UNICODE) , 
                    'image'              => "5.png",
                    'type'              => 'doctor', 
                    'created_at'        => Carbon::now()
                ]
                ,[
                    'name'              => json_encode(['en' => 'beauty centers'  , 'ar' => 'مراكز التجميل' , 'kur' => 'navendên bedewiyê'] , JSON_UNESCAPED_UNICODE) , 
                    'image'              => "6.png",
                    'type'              => 'doctor', 
                    'created_at'        => Carbon::now()
                ]
                ,[
                    'name'              => json_encode(['en' => 'Laboratories'  , 'ar' => 'المختبرات' , 'kur' => 'Laboratories'] , JSON_UNESCAPED_UNICODE) , 
                    'image'             => "7.png",
                    'type'              => 'lab' , 
                    'created_at'        => Carbon::now() 
                ]
            ]);

        DB::table('categories')->insert([
            
             [
                'parent_id'         => 2 ,
                'name'              => json_encode(['en' => 'coulons'  , 'ar' => 'امراض القولون' , 'kur' => 'test'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'coulon.png',
                'type'              => 'doctor', 
            ] 
            , [
                'parent_id'         => 2 ,
                'name'              => json_encode(['en' => 'nose ear and throat'  , 'ar' => 'التهاب العظام' , 'kur' => 'test'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'bone1.png',
                'type'              => 'doctor', 
            ]
            , [
                'parent_id'         => 2 ,
                'name'              => json_encode(['en' => 'backbone'  , 'ar' => 'التهاب الفقرات' , 'kur' => 'backbone'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'bone2.png',
                'type'              => 'doctor', 
            ]
            ,
            [
                'parent_id'         => 3 ,
                'name'              => json_encode(['en' => 'middle ear'  , 'ar' => 'الاذن الوسطي', 'kur' => 'guhê navîn'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'obstetrics.png',
                'type'              => 'doctor', 
            ] , [
                'parent_id'         => 3 ,
                'name'              => json_encode(['en' => 'Psychiatry'  , 'ar' => 'التهاب الحلق' , 'kur' => 'Gevî êş'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'Psychiatry.png',
                'type'              => 'doctor', 
            ] 
            , [
                'parent_id'         => 4 ,
                'name'              => json_encode(['en' => 'molares'  , 'ar' => 'الانحرافات المولرية' , 'kur' => 'aberrations'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'woman2',
                'type'              => 'doctor', 
            ] ,[
                'parent_id'         => 4 ,
                'name'              => json_encode(['en' => 'miscarriage'  , 'ar' => 'الاجهاض' , 'kur' => 'zarok ji ber çûn'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'woman1',
                'type'              => 'doctor', 
            ] ,
            [
                'parent_id'         => 5 ,
                'name'              => json_encode(['en' => 'Schizophrenia'  , 'ar' => 'الفصام' , 'kur' => 'Şîzofrenî'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'mental2.jpg',
                'type'              => 'doctor', 
            ] ,[
                'parent_id'         => 5 ,
                'name'              => json_encode(['en' => 'depression'  , 'ar' => 'الاكتئاب' , 'kur' => 'zarok ji ber çûn'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'mental2.jpg',
                'type'              => 'doctor', 
            ] ,

            [
                'parent_id'         => 6 ,
                'name'              => json_encode(['en' => 'warts'  , 'ar' => 'الثآليل' , 'kur' => 'wartsI'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'Laboratories.png',
                'type'              => 'doctor', 
                
            ] ,[
                'parent_id'         => 6 ,
                'name'              => json_encode(['en' => 'Boils'  , 'ar' => 'الدمامل' , 'kur' => 'Boilse'] , JSON_UNESCAPED_UNICODE) , 
                'image'             => 'Laboratories.png',
                'type'              => 'doctor', 
            ] ,
            
        ]);
    }
}
