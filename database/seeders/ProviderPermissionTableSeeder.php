<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ProviderPermissionTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $data = [
            [
                'provider_rule_id' => 1,
                'permission'       => 'doctor.reservations.refuse',
            ],
            [
                'provider_rule_id' => 1,
                'permission'       => 'doctor.reservations.accept',
            ],

            [
                'provider_rule_id' => 2,
                'permission'       => 'doctor.medicine.index',
            ],
            [
                'provider_rule_id' => 2,
                'permission'       => 'doctor.medicine.create',
            ],
            [
                'provider_rule_id' => 2,
                'permission'       => 'doctor.medicine.store',
            ],
            [
                'provider_rule_id' => 2,
                'permission'       => 'doctor.medicine.edit',
            ],
            [
                'provider_rule_id' => 2,
                'permission'       => 'doctor.medicine.update',
            ],
            [
                'provider_rule_id' => 2,
                'permission'       => 'doctor.medicine.delete',
            ],

            [
                'provider_rule_id' => 3,
                'permission'       => 'doctor.reservations.writePrescription',
            ],
        ];
        DB::table('provider_permissions')->insert($data);
        Cache::forget('lockedRoutes');
    }
}
