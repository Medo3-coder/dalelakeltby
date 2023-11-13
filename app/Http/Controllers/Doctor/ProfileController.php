<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Profile\PermitRequest;
use App\Http\Requests\Doctor\Profile\ProfileRequest;
use App\Http\Requests\Doctor\Profile\UpdateStoreRequest;
use App\Http\Requests\Pharmacy\Profile\PermitUpdateRequest;
use App\Models\Category;
use App\Models\ClinicDate;
use App\Models\ClinicImages;
use App\Models\Country;
use App\Models\StoreBranchImage;
use App\Models\StoreDate;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use UploadTrait;
    private $data = [];

    public function checkTimes($request)
    {
        $timesArray = $request['times'];
        $check = 'true';
        foreach ($request['index'] as $i){
            if ($timesArray['days-' . $i]) {

                $array = $timesArray['days-' . $i];

                $unique = array_unique($array);

                $times = [];

                foreach ($unique as $value){
                    $duplicated = array_keys(array_intersect($array, $unique), $value);
                    $from = array_values(array_intersect_key($timesArray['from-'. $i], array_flip($duplicated)));
                    $to = array_values(array_intersect_key($timesArray['to-' . $i], array_flip($duplicated)));
                    $times[] = [$value=>['from'=>$from, 'to'=>$to]];

                }

                foreach ($times as  $values){
                    foreach ($values as $value){

                        $count = count($value['from']);
                        for ($i = 0; $i < $count; $i++) {

                            if ($value['from'][$i] && $value['to'][$i]) {
                                $start = Carbon::createFromTimeString($value['from'][$i]);
                                $end = Carbon::createFromTimeString($value['to'][$i]);


                                for ($i2 = 0; $i2 < $count; $i2++) {
                                    if ($i2 != $i) {

                                        $previos_from = Carbon::createFromTimeString($value['from'][$i2]);
                                        $previos_to = Carbon::createFromTimeString($value['to'][$i2]);

                                        if ($start->between($previos_from, $previos_to) || $end->between($previos_from, $previos_to, false)) {
                                            $check = 'false';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $check;
    }
    public function index()
    {
        Carbon::setLocale(app()->getLocale());
        $doctor             =   authUser('doctor');
        $firstBranch        =   $doctor->branches()->first();
        $branches           =   $doctor->branches()->where('id', '<>', $firstBranch['id'])->get();
        $permits            =   $doctor->permits()->orderBy('created_at', 'DESC')->get();
        $countries          =   Country::all();
        $i                  =   0;
        $categories         =   Category::where(['type' => 'doctor', 'parent_id' => null])->get();
        $subCategory        =   $doctor->category;
        $singleCategory     =   $subCategory->parent_id != null ? Category::find($subCategory->parent_id) : false;
        $this->data = [
            'doctor'        =>  $doctor,
            'firstBranch'   =>  $firstBranch,
            'branches'      =>  $branches,
            'permits'       =>  $permits,
            'countries'     =>  $countries,
            'i'             =>  $i,
            'categories'    =>  $categories,
            'subCategory'   =>  $subCategory,
            'singleCategory'=>  $singleCategory
        ];
        return view('providers_dashboards.doctor.profile.index')->with($this->data);
    }

    public function getSubSpecialities($id) {
        $subspecialities = Category::findOrFail($id)->childes;
        $doctor             =   authUser('doctor');
        return response()->json(['html' => view('providers_dashboards.doctor.auth.register.includes.html.register.sub_speciality_select', compact('subspecialities', 'doctor'))->render()]);
    }

    public function permitStore(PermitRequest $request)
    {
        $store              = authUser('doctor');
        $msg                        = __('store.Congratulations!') . ' ' . __('translation.The qualification has been added successfully');
        $store->permits()->create($request->validated());

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=> route('doctor.profile')]);
    }

    public function permitUpdate(PermitUpdateRequest $request)
    {
        $doctor                   = authUser('doctor');
        $doctor->update($request->validated());
        $msg = __('translation.The data has been modified successfully');
        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('doctor.profile')]);
    }

    public function permitDelete(Request $request)
    {
        $store              = authUser('doctor');
        $msg                =  __('store.Congratulations!') . ' ' .  __('translation.The qualification has been deleted successfully');
        $store->permits()->findOrFail($request->id)->delete();

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('doctor.profile')]);
    }

    public function profileUpdate(ProfileRequest $request)
    {
        $requestValid       =   $request->validated();
        $doctor             =   authUser('doctor');
        $oldPhone           =   $doctor->phone;
        $oldCountryCode     =   $doctor->country_code;

        $doctor->update($requestValid);

        if ($oldPhone != $requestValid['phone'] || $oldCountryCode != $requestValid['country_code']){
            $doctor->sendPhoneActivationCode();
            $doctor->update(['is_active'=>0]);
        }

        $msg =  __('store.Congratulations!') . ' ' . __('store.Profile modified successfully');

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('doctor.profile')]);
    }

    public function doctorUpdate(UpdateStoreRequest $request)
    {
        $requestValidated= $request->validated();

        if ($this->checkTimes($request) == 'false'){
            $msg = __('store.Error in working hours');
            return response()->json(['key'=>'fail', 'msg'=>$msg]);
        }


        $doctor              =   authUser('doctor');
        $firstBranch        =   $doctor->branches()->first();
        $doctor->branches()->where('id', '<>', $firstBranch['id'])->whereNotIn('id', $requestValidated['ids'])->delete();

        foreach ($request['index'] as $i){
            $data = [
                'name'                          =>  $request['name'][$i],
                'lat'                           =>  $request['lat'][$i],
                'lng'                           =>  $request['lng'][$i],
                'address'                       =>  $request['address'][$i],
                'address_map'                   =>  $request['address_map'][$i],
                'comerical_record'              =>  $request['comerical_record'][$i],
                'detection_price'               =>  $request['detection_price'][$i]
            ];

            if ($request['ids'][$i] != 0  && $request['images-' . $i][0] == null && !isset($request['imagesIds-' . $i])){
                $msg = __('store.msg_error_delete_images');
                return response()->json(['key'=>'fail', 'msg'=>$msg]);
            }

            $branch = $doctor->branches()->updateOrCreate(['id'=>$requestValidated['ids'][$i]], $data);
            $times  = [];
            $images = [];

            foreach ($request['times']['days-' . $i] as $key => $value){

                $times[] = [
                    'clinic_id'             =>  $branch['id'],
                    'day'                   =>  $value,
                    'from'                  =>  $request['times']['from-' . $i][$key],
                    'to'                    =>  $request['times']['to-' . $i][$key],
                    'created_at'            =>  Carbon::now(),
                    'updated_at'            =>  Carbon::now(),
                ];
            }

            if ($request['images-' . $i][0] != null){
                foreach ($request['images-' . $i] as $image){
                    $images[] = [
                        'clinic_id'             =>  $branch['id'],
                        'image'                 => $this->uploadeImage($image, 'clinicimages'),
                        'created_at'            =>  Carbon::now(),
                        'updated_at'            =>  Carbon::now(),
                    ];
                }
            }

            $branch->dates()->delete();
            $imagesIds = !isset($request['imagesIds-' . $i]) ? [] : $request['imagesIds-' . $i];
            $branch->images()->whereNotIn('id', $imagesIds)->delete();

            ClinicDate::insert($times);
            ClinicImages::insert($images);

        }

        $msg = __('store.Congratulations!'). ' ' . __('store.The clinic has been modified successfully');
        return response()->json(['status'=>'success', 'url'=>route('doctor.profile'), 'msg'=>$msg]);
    }

    public function doctorDelete(Request $request)
    {
        if ($request->ajax()){
            $store  =   authUser('doctor');
            $url    =   route('doctor.showLogin');
            $msg    =   __('store.Congratulations!') . ' ' . __('store.Your account has been deleted successfully');
            $store->delete();
            Auth::guard('doctor')->logout();
            return response()->json(['status'=>'success', 'url'=>$url, 'msg'=>$msg]);
        }
    }
}
