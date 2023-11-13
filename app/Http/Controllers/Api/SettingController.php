<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Coupon\checkCouponRequest;
use App\Http\Requests\Api\User\SiteMessageRequest;
use App\Http\Resources\Api\BloodTypeResource;
use App\Http\Resources\Api\CategoriesResource;
use App\Http\Resources\Api\ChranicDiseasesResource;
use App\Http\Resources\Api\MedicalAdvices\MedicalAdviceDetailsResource;
use App\Http\Resources\Api\MedicalAdvices\MedicalAdvicesCollection;
use App\Http\Resources\Api\Settings\CityResource;
use App\Http\Resources\Api\Settings\CountryResource;
use App\Http\Resources\Api\Settings\CountryWithCitiesResource;
use App\Http\Resources\Api\Settings\FqsResource;
use App\Http\Resources\Api\Settings\ImageResource;
use App\Http\Resources\Api\Settings\IntroResource;
use App\Http\Resources\Api\Settings\SocialResource;
use App\Http\Resources\Api\SpecialtyResource;
use App\Models\BloodType;
use App\Models\Category;
use App\Models\ChranicDisease;
use App\Models\City;
use App\Models\Country;
use App\Models\Fqs;
use App\Models\Image;
use App\Models\Intro;
use App\Models\MedicalAdvice;
use App\Models\SiteMessage;
use App\Models\SiteSetting;
use App\Models\Social;
use App\Models\Specialty;
use App\Services\CouponService;
use App\Services\SettingService;
use App\Traits\ResponseTrait;

class SettingController extends Controller {
    use ResponseTrait;

    public function specialties() {
        return CategoriesResource::collection(Category::where('type', 'doctor')->latest()->get());

    }

    public function medicalAdvices() {
        return $this->successData(new MedicalAdvicesCollection(MedicalAdvice::latest()->paginate(30)));
    }

    public function medicalAdviceDetails($id) {
        return $this->successData(new MedicalAdviceDetailsResource(MedicalAdvice::findOrFail($id)));
    }

    public function howWork() {
        return $this->successData(SiteSetting::where(['key' => 'how_work_' . lang()])->first()->value);
    }

    public function fqss() {
        $fqss = FqsResource::collection(Fqs::latest()->get());
        return $this->successData($fqss);
    }

    public function settings() {
        $data = SettingService::appInformations(SiteSetting::pluck('value', 'key'));
        return $this->successData($data);
    }

    public function about() {
        $about = SiteSetting::where(['key' => 'about_' . lang()])->first()->value;
        return $this->successData($about);
    }

    public function terms() {
        $terms = SiteSetting::where(['key' => 'terms_' . lang()])->first()->value;
        return $this->successData($terms);
    }

    public function privacy() {
        $privacy = SiteSetting::where(['key' => 'privacy_' . lang()])->first()->value;
        return $this->successData($privacy);
    }

    public function intros() {
        $intros = IntroResource::collection(Intro::latest()->get());
        return $this->successData($intros);
    }

    public function socials() {
        $socials = SocialResource::collection(Social::latest()->get());
        return $this->successData($socials);
    }

    public function images($id = null) {
        $images = ImageResource::collection(Image::latest()->get());
        return $this->successData($images);
        //$images = ImageResource::collection(Image::paginate(1));
    }

    public function categories($id = null) {
        $categories = CategoriesResource::collection(Category::where('parent_id', $id)->latest()->get());
        return $this->successData($categories);
    }

    public function countries() {
        $countries = CountryResource::collection(Country::latest()->get());
        return $this->successData($countries);
    }

    public function cities() {
        $cities = CityResource::collection(City::latest()->get());
        return $this->successData($cities);
    }

    public function CountryCities($country_id) {
        $cities = CityResource::collection(City::where('country_id', $country_id)->latest()->get());
        return $this->successData($cities);
    }

    public function countriesWithCities() {
        $countries = CountryWithCitiesResource::collection(Country::with('cities')->latest()->get());
        return $this->successData($countries);
    }

    public function specialitiesAndCities() {
        return $this->successData([
            'specialities' => CategoriesResource::collection(Category::where('type', 'doctor')->latest()->get()),
            'cities'       => CityResource::collection(City::latest()->get()),
        ]);
    }

    public function checkCoupon(checkCouponRequest $request) {
        $checkCouponRes = CouponService::checkCoupon($request->coupon_num, $request->total_price);
        return $this->response($checkCouponRes['key'], $checkCouponRes['msg'], $checkCouponRes['data'] ?? null);
    }
    public function isProduction() {
        $isProduction = SiteSetting::where(['key' => 'is_production'])->first()->value;
        return $this->successData($isProduction);
    }

    public function bloodtypesAndDiseases() {
        $diseases   = ChranicDisease::orderBy('name', 'desc')->get();
        $bloodTypes = BloodType::all();
        // response data
        $data               = [];
        $data['diseases']   = ChranicDiseasesResource::collection($diseases);
        $data['bloodTypes'] = BloodTypeResource::collection($bloodTypes);
        return $this->successData($data);
    }

    public function bloodtypes() {
        $bloodTypes = BloodType::all();
        // response data
        $data               = [];
        $data['bloodTypes'] = BloodTypeResource::collection($bloodTypes);
        return $this->successData($data);
    }

    public function diseases() {
        $diseases = ChranicDisease::orderBy('name', 'desc')->get();
        return $this->successData(ChranicDiseasesResource::collection($diseases));
    }

    public function contact(SiteMessageRequest $request) {
        SiteMessage::create($request->validated());
        return $this->successMsg(trans('apis.messageSended'));
    }

    public function registerData() {
        return $this->successData([
            'chranic_disease' => ChranicDiseasesResource::collection(ChranicDisease::latest()->get()),
            'blood_types'     => BloodTypeResource::collection(BloodType::get()),
            'countries'       => CountryResource::collection(Country::latest()->get()),
        ]);
    }

    public function providersLinks() {
        return $this->successData([
            'doctor'   => route('doctor.chooseLogin'),
            'store'    => route('store.chooseLogin'),
            'pharmacy' => route('pharmacy.chooseLogin'),
            'lab'      => route('lab.chooseLogin'),
        ]);
    }
}
