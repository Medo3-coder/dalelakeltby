<?php
namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('countries')->insert([
            [
                'name'       => json_encode(['ar' => 'السعودية', 'en' => 'Saudi Arabia', 'kur' => 'Saudi Arabia'], JSON_UNESCAPED_UNICODE),
                'key'        => '966',
                'image'      => "Flag-Saudi.webp",
                'created_at' => \Carbon\Carbon::now()->subMonth(rand(0, 6)),
            ], [
                'name'       => json_encode(['ar' => 'مصر', 'en' => 'Egypt', 'kur' => 'Egypt'], JSON_UNESCAPED_UNICODE),
                'key'        => '20',
                'image'      => 'Flag-Egypt.webp',
                'created_at' => \Carbon\Carbon::now()->subMonth(rand(0, 6)),

            ], [
                'name'       => json_encode(['ar' => 'الامارات', 'en' => 'UAE', 'kur' => 'UAE'], JSON_UNESCAPED_UNICODE),
                'key'        => '971',
                'image'      => "UAE-flag.jpg",
                'created_at' => \Carbon\Carbon::now()->subMonth(rand(0, 6)),

            ], [
                'name'       => json_encode(['ar' => 'البحرين', 'en' => 'El-Bahrean', 'kur' => 'El-Bahrean'], JSON_UNESCAPED_UNICODE),
                'key'        => '973',
                'image'      => 'bahrain.png',
                'created_at' => \Carbon\Carbon::now()->subMonth(rand(0, 6)),

            ], [
                'name'       => json_encode(['ar' => 'قطر', 'en' => 'Qatar', 'en' => 'kur'], JSON_UNESCAPED_UNICODE),
                'key'        => '974',
                'image'      => 'Flag-Qatar.png',
                'created_at' => \Carbon\Carbon::now()->subMonth(rand(0, 6)),

            ], [
                'name'       => json_encode(['ar' => 'ليبيا', 'en' => 'Libya', 'kur' => 'Libya'], JSON_UNESCAPED_UNICODE),
                'key'        => '218',
                'image'      => 'Flag-Libya.webp',
                'created_at' => \Carbon\Carbon::now()->subMonth(rand(0, 6)),

            ], [
                'name'       => json_encode(['ar' => 'الكويت', 'en' => 'Kuwait', 'kur ' => 'Kuwait'], JSON_UNESCAPED_UNICODE),
                'key'        => '965',
                'image'      => 'kuwait-flag.jpg',
                'created_at' => \Carbon\Carbon::now()->subMonth(rand(0, 6)),

            ], [
                'name'       => json_encode(['ar' => 'عمان', 'en' => 'Oman', 'kur' => 'Oman'], JSON_UNESCAPED_UNICODE),
                'key'        => '968',
                'image'      => 'Flag-Oman.webp',
                'created_at' => \Carbon\Carbon::now()->subMonth(rand(0, 6)),

            ],
        ]);
    }
}
