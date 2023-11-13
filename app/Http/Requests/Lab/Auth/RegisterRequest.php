<?php

namespace App\Http\Requests\Lab\Auth;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest {

    public function __construct() {
//        dd(request()->all());
        request()['category_id'] = Category::where('type', 'lab')->first()->id;
    }

    public function authorize() {
        return true;
    }

    public function custom() {
        $rules = [
            'name'                                 => 'required|string|min:3|max:199',
            'lab_name'                             => 'required|string|min:3|max:199',
            'address'                              => 'required|string',
            'image'                                => 'required|image',
            'country_code'                         => 'required',
            'phone'                                => 'required|numeric|digits_between:8,10|unique:stores,phone,NULL,id,deleted_at,NULL',
            'email'                                => 'required|email|unique:stores,email,NULL,id,deleted_at,NULL',
            'city_id'                              => 'required|exists:cities,id',
            'identity_id'                          => 'required|numeric|digits_between:12,20',
            'identity_image'                       => 'required|image',
            'category_id'                          => 'required',

            'category_ids'                         => 'required|array',
            'category_ids.*'                       => 'required',

            'branches'                             => 'required|array',
            'branches.*.name'                      => 'required',
            'branches.*.lat'                       => 'required|numeric',
            'branches.*.lng'                       => 'required|numeric',
            'branches.*.address'                   => 'required',
            'branches.*.address_map'               => 'required',
            'branches.*.comerical_record'          => 'required|numeric',
            'branches.*.opening_certificate_image' => 'required|image',
            'branches.*.opening_certificate_pdf'   => 'required|mimes:pdf',
            'branches.*.images'                    => 'required|array',
            'branches.*.images.*'                  => 'required|image',

            'branches.*.dates'                     => 'required|array',
            'branches.*.dates.*.day'               => 'required',
            'branches.*.dates.*.from'              => 'required',
            'branches.*.dates.*.to'                => 'required',

            'labCategories'                        => 'required|array',
            'labCategories.*'                      => 'required|array',
            'labCategories.*.*'                    => 'required|array',
            'labCategories.*.*.sub_category_id'    => 'required|exists:lab_categories,id',
            'labCategories.*.*.lab_category_id'    => 'required|exists:lab_categories,id',
            'labCategories.*.*.price'              => 'required|numeric',
            'labCategories.*.*.unit'               => 'required',
            'labCategories.*.*.normal_range'       => 'required',
            'labCategories.*.*.targeted_bodies'    => 'nullable|array',
            'labCategories.*.*.targeted_bodies.*'  => 'required|exists:target_body_areas,id',

            'password'                             => 'required|min:6',
            'password_confirmation'                => 'required|same:password',

        ];

        $attributes = [];

        foreach (request()->branches as $index => $branch) {
            $attributes['branches.' . $index . '.name']                      = __('localize.branch_name');
            $attributes['branches.' . $index . '.lat']                       = __('doctor.lat');
            $attributes['branches.' . $index . '.lng']                       = __('doctor.lng');
            $attributes['branches.' . $index . '.address']                   = __('doctor.address');
            $attributes['branches.' . $index . '.comerical_record']          = __('doctor.comerical_record');
            $attributes['branches.' . $index . '.opening_certificate_image'] = __('localize.opening_certificate_image');
            $attributes['branches.' . $index . '.opening_certificate_pdf']   = __('localize.opening_certificate_pdf');
            $attributes['branches.' . $index . '.images']                    = __('localize.images');
            $attributes['branches.' . $index . '.date']                      = __('doctor.working_times');

            foreach ($branch['dates'] as $date_index => $date) {
                $attributes['branches.' . $index . '.dates.' . $date_index . '.day']  = __('doctor.day');
                $attributes['branches.' . $index . '.dates.' . $date_index . '.from'] = __('doctor.from');
                $attributes['branches.' . $index . '.dates.' . $date_index . '.to']   = __('doctor.to');
            }
        }

        if (is_array(request()->labCategories)) {
            foreach (request()->labCategories as $category_index => $subcategories) {
                for ($i = 0; $i < count($subcategories); $i++) {
                    $attributes['labCategories.' . $category_index . '.' . $i . '.sub_category_id'] = __('localize.sub_category_id');
                    $attributes['labCategories.' . $category_index . '.' . $i . '.price']           = __('localize.price');
                    $attributes['labCategories.' . $category_index . '.' . $i . '.unit']            = __('localize.unit');
                    $attributes['labCategories.' . $category_index . '.' . $i . '.normal_range']    = __('localize.normal_range');
                    $attributes['labCategories.' . $category_index . '.' . $i . '.targeted_bodies'] = __('localize.targeted_bodies');

                    if (isset($subcategories['targeted_bodies']) && is_array($subcategories['targeted_bodies'])) {
                        for ($a = 0; $a < count($subcategories['targeted_bodies']); $a++) {
                            $attributes['labCategories.' . $category_index . '.' . $i . '.targeted_bodies.' . $a] = __('localize.targeted_body_area');
                        }
                    }
                }
            }
        }

        return [
            'rules'      => $rules,
            'attributes' => $attributes,
        ];

    }

    public function rules() {
        return $this->custom()['rules'];
    }

    public function prepareForValidation() {
        $this->merge([
            'phone'        => fixPhone($this->phone),
            'country_code' => fixPhone($this->country_code),
        ]);
    }

    public function attributes() {
        return $this->custom()['attributes'];
    }

}

/*  this is an example form the request data from the regester form

"_token" => "levq5FyM4bySwqBwNnXU8KDgsE27mlGWBeOsv7Ux"
"name" => "345345"
"address" => "345345345345"
"country_code" => "966"
"phone" => "345345345345"
"email" => "a@a.aaaa"
"city_id" => "13"
"identity_id" => "345345345"
"branches" => array:2 [
    0 => array:9 [
        "name" => "345345"
        "lat" => "31.032397"
        "lng" => "31.396475"
        "address" => "المنصورة (قسم 2)، الدقهلية 7661016، مصر"
        "comerical_record" => "345345"
        "dates" => array:2 [
        0 => array:3 [
            "day" => "sunday"
            "from" => "12:00"
            "to" => "15:00"
            ]
        1 => array:3 [
        "day" => "wednesday"
        "from" => "15:00"
        "to" => "18:00"
        ]
        ]
        "opening_certificate_image" => Illuminate\Http\UploadedFile
        "opening_certificate_pdf" => Illuminate\Http\UploadedFile
        "images" => array:2 [
        0 => Illuminate\Http\UploadedFile
        1 => Illuminate\Http\UploadedFile
        ]
        ]
        1 => array:9 [
        "name" => "hrthrhrth"
        "lat" => "40.72950505812345"
        "lng" => "-73.82476486243353"
        "address" => "Kew Gardens Hills, NY 11367، الولايات المتحدة"
        "comerical_record" => "45456456546"
        "dates" => array:3 [
        0 => array:3 [
        "day" => "sunday"
        "from" => "12:00"
        "to" => "17:00"
        ]
        2 => array:3 [
        "day" => "sunday"
        "from" => "12:00"
        "to" => "18:00"
        ]
        3 => array:3 [
        "day" => "monday"
        "from" => "13:00"
        "to" => "18:00"
        ]
        ]
        "opening_certificate_image" => Illuminate\Http\UploadedFile
        "opening_certificate_pdf" => Illuminate\Http\UploadedFile
        "images" => array:1 [
        0 => Illuminate\Http\UploadedFile
        ]
        ]
        ]
        "labCategories" => array:3 [
        0 => array:3 [
        0 => array:5 [
        "sub_category_id" => "20"
        "price" => "346"
        "unit" => "wef"
        "normal_range" => "1111786797"
        "targeted_bodies" => array:9 [
        0 => "3"
        1 => "5"
        2 => "6"
        3 => "8"
        4 => "10"
        5 => "13"
        6 => "14"
        7 => "18"
        8 => "19"
        ]
        ]
        1 => array:5 [
        "sub_category_id" => "14"
        "price" => "345"
        "unit" => "ef"
        "normal_range" => "44444444"
        "targeted_bodies" => array:10 [
        0 => "3"
        1 => "5"
        2 => "6"
        3 => "7"
        4 => "8"
        5 => "11"
        6 => "13"
        7 => "14"
        8 => "15"
        9 => "16"
        ]
        ]
        2 => array:5 [
        "sub_category_id" => "9"
        "price" => "346"
        "unit" => "erg"
        "normal_range" => "44444444"
        "targeted_bodies" => array:9 [
        0 => "3"
        1 => "4"
        2 => "5"
        3 => "8"
        4 => "9"
        5 => "10"
        6 => "13"
        7 => "14"
        8 => "20"
        ]
        ]
        ]
        1 => array:2 [
        0 => array:3 [
        "price" => "344"
        "unit" => "345345"
        "normal_range" => "345345345"
        ]
        1 => array:4 [
        "sub_category_id" => "21"
        "price" => "345344"
        "unit" => "345345"
        "normal_range" => "345345"
        ]
        ]
        2 => array:1 [
        0 => array:5 [
        "sub_category_id" => "17"
        "price" => "345"
        "unit" => "345"
        "normal_range" => "345"
        "targeted_bodies" => array:9 [
        0 => "1"
        1 => "6"
        2 => "7"
        3 => "8"
        4 => "11"
        5 => "12"
        6 => "13"
        7 => "18"
        8 => "19"
        ]
        ]
        ]
        ]
        "password" => "123456"
        "password_confirmation" => "123456"
        "image" => Illuminate\Http\UploadedFile
        "identity_image" => Illuminate\Http\UploadedFile
        ]
        */
