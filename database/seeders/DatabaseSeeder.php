<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run() {
        $this->call(SettingSeeder::class);
        $this->call(BloodTypeTableSeeder::class);
        $this->call(ChranicDiseasesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ChranicDiseaseUserTableSeeder::class);
        $this->call(IntroHowWorkTableSeeder::class);
        $this->call(IntroSliderTableSeeder::class);
        $this->call(IntroServiceTableSeeder::class);
        $this->call(IntroFqsCategoryTableSeeder::class);
        $this->call(IntroFqsTableSeeder::class);
        $this->call(IntroPartenerTableSeeder::class);
        $this->call(IntroSocialTableSeeder::class);
        $this->call(SocialTableSeeder::class);

        $this->call(CategoryTableSeeder::class);

        $this->call(CountryTableSeeder::class);
        $this->call(RegionTableSeeder::class);
        $this->call(CityTableSeeder::class);

        // $this->call(ComplaintTableSeeder::class);
        $this->call(LabCategoryTableSeeder::class);
        $this->call(TargetBodyAreaTableSeeder::class);
        $this->call(LabTableSeeder::class);
        $this->call(CategoryLabTableSeeder::class);
        $this->call(DoctorTableSeeder::class);
        $this->call(LabBranchTableSeeder::class);
        $this->call(LabDatesTableSeeder::class);

        $this->call(ClinicsTableSeeder::class);
        $this->call(ClinicDatesTableSeeder::class);
        $this->call(ClinicImagesTableSeeder::class);

        $this->call(ReservationTableSeeder::class);
        $this->call(ReservationImagesTableSeeder::class);
        $this->call(RagitesTableSeeder::class);
        $this->call(MedicalRecordsTableSeeder::class);
        $this->call(DoctorMedicineTableSeeder::class);
        $this->call(MedicalRecordMedicansTableSeeder::class);

        $this->call(PharmacistTableSeeder::class);
        // $this->call(PharmacyTableSeeder::class);
        $this->call(PharmacyBranchesTableSeeder::class);
        $this->call(PharmacyDateTableSeeder::class);
        $this->call(PharmacyBranchImagesTableSeeder::class);

        $this->call(FqsTableSeeder::class);
        $this->call(IntroTableSeeder::class);
        $this->call(ImageTableSeeder::class);
        $this->call(CouponTableSeeder::class);
        $this->call(SmsTableSeeder::class);
        // $this->call(NotificationSeeder::class);
        $this->call(SpecialtyTableSeeder::class);
        $this->call(Store1TableSeeder::class);
        $this->call(StoreBranchTableSeeder::class);
        $this->call(StoreBranchDatesTableSeeder::class);
        $this->call(StoreBranchImagesTableSeeder::class);
        $this->call(StorePermitSeeder::class);
        $this->call(ProductAdditiveCategorySeeder::class);


        $this->call(FeaturesTableSeeder::class);
         $this->call(ProperitiesTableSeeder::class);
        $this->call(ProductCategoriesTableSeeder::class);
        $this->call(ProductsSeeder::class);
        $this->call(ProductfeaturesTableSeeder::class);
        // $this->call(ProductfeatureproperitiesSeeder::class);
        $this->call(ProductgroupsTableSeeder::class);
        $this->call(OfferSeeder::class);
        $this->call(StoreCouponsSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(OrderProductsTableSeeder::class);
        $this->call(MedicalAdviceTableSeeder::class);
        $this->call(SiteMessageTableSeeder::class);
        $this->call(SiteFeatureTableSeeder::class);
        $this->call(AppPageTableSeeder::class);
        $this->call(CancelReasonTableSeeder::class);

        // $this->call(ProviderRulesTableSeeder::class);
        // $this->call(ProviderPermissionTableSeeder::class);
        //    $this->call(SettlementTableSeeder::class);

    }
}
