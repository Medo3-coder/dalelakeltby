<?php

namespace Database\Seeders;

use App\Models\Lab;
use App\Models\LabCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryLabTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // create lab categories
        $labs           = Lab::get();
        $labsCategories = [];
        foreach ($labs as $lab) {
            $labsCategories[] = [
                'lab_id'          => $lab->id,
                'lab_category_id' => rand(1, 3),
            ];
        }
        DB::table('categories_labs')->insert($labsCategories);

        // create lab sub categories
        $labSubCategories = [];
        $subCategories    = LabCategory::where('parent_id', '!=', null);
        foreach ($labsCategories as $labCategory) {
            for ($i = 0; $i < 4; $i++) {
                $labSubCategories[] = [
                    'lab_id'          => $labCategory['lab_id'],
                    'lab_category_id' => $labCategory['lab_category_id'],
                    'sub_category_id' => LabCategory::where('parent_id', '!=', null)->where('parent_id', $labCategory['lab_category_id'])->orderBy(DB::raw('RAND()'))->get()->first()->id,
                    'price'           => rand(10, 999),
                    'unit'            => '10^3/UL',
                    'normal_range'    => '15 - 20',
                ];
            }
        }
        DB::table('sub_category_labs')->insert($labSubCategories);

        // create subcategories targeted bodies areas
        $hasTargetedBodiesAreasSubCategories = $subCategories->whereIn('parent_id', [1, 3])->pluck('id')->toArray();
        $subcategoriesTargetedBodies         = [];
        foreach ($labSubCategories as $id => $labSubCategory) {
            if (in_array($labSubCategory['sub_category_id'], $hasTargetedBodiesAreasSubCategories)) {
                for ($i = 1; $i <= rand(3, 20); $i++) {
                    $subcategoriesTargetedBodies[] = [
                        'sub_category_lab_id' => $id + 1,
                        'target_body_id'      => $i,
                    ];
                }
            }
        }
        DB::table('sub_categories_labs_targeted_bodies')->insert($subcategoriesTargetedBodies);
    }
}
