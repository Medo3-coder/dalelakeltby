<?php

namespace Database\Seeders;



use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        DB::table('specialties')->insert([
            [
                'name'              => json_encode(['en' => 'nursing', 'ar' => 'التمريض', 'kur' => 'lênerrîn'], JSON_UNESCAPED_UNICODE),
                'created_at'        => Carbon::now()
            ], 
            [
                'name'              => json_encode(['en' => 'general medicine', 'ar' => 'الطب العام', 'kur' => 'Dermanê Giştî'], JSON_UNESCAPED_UNICODE),
                'created_at'        => Carbon::now()
            ], 
            [
                'name'              => json_encode(['en' => 'Childrens medicine', 'ar' => 'طب الأطفال', 'kur' => 'Pediatrics'], JSON_UNESCAPED_UNICODE),
                'created_at'        => Carbon::now()
            ],
             [
                'name'              => json_encode(['en' => 'dentist', 'ar' => 'طب الأسنان', 'kur' => 'pizişka didanan'], JSON_UNESCAPED_UNICODE),
                'created_at'        => Carbon::now()
            ], 
            [
                'name'              => json_encode(['en' => 'Heart Surgery', 'ar' => 'جراحة القلب', 'kur' => 'Neştergeriya Dil'], JSON_UNESCAPED_UNICODE),
                'created_at'        => Carbon::now()
            ],

        ]);

        DB::table('specialties')->insert([
            [
                'parent_id'         => 1,
                'name'              => json_encode(['en' => 'Kidney disease', 'ar' => 'أمراض الكلى', 'kur' => 'Nexweşiya gurçikê'], JSON_UNESCAPED_UNICODE),
            ],
             [
                'parent_id'         => 2,
                'name'              => json_encode(['en' => 'Plastic surgery', 'ar' => 'الجراحات التجميلية', 'kur' => 'Cerahiya plastîk'], JSON_UNESCAPED_UNICODE),
            ],
             [
                'parent_id'         => 3,
                'name'              => json_encode(['en' => 'Brain surgery', 'ar' => 'جراحة الدماغ', 'kur' => 'Emeliyata mêjî'], JSON_UNESCAPED_UNICODE),
            ],
             [
                'parent_id'         => 4,
                'name'              => json_encode(['en' => 'Visual medicine', 'ar' => 'الطب البصري', 'kur' => 'dermanê dîtbarî'], JSON_UNESCAPED_UNICODE),
            ],
             [
                'parent_id'         => 5,
                'name'              => json_encode(['en' => 'Medical tests', 'ar' => 'التحاليل الطبية ', 'kur' => 'lênerrîn'], JSON_UNESCAPED_UNICODE),
            ],
             [
                'parent_id'         => 2,
                'name'              => json_encode(['en' => 'organ transplant', 'ar' => 'زراعة الاعضاء', 'kur' => 'veguheztina organan'], JSON_UNESCAPED_UNICODE),

            ],
      

        ]);
    }
}
