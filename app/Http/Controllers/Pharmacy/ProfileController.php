<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\Profile\PermitRequest;
use App\Http\Requests\Pharmacy\Profile\PermitUpdateRequest;
use App\Http\Requests\Pharmacy\Profile\ProfileRequest;
use App\Http\Requests\Pharmacy\Profile\UpdateStoreRequest;
use App\Models\ClinicDate;
use App\Models\ClinicImages;
use App\Models\Country;
use App\Models\LabBranchDate;
use App\Models\LabBranchImage;
use App\Models\PharmacyBranchImage;
use App\Models\PharmacyDate;
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
        $pharmacy                =   authUser('pharmacy');
        $firstBranch        =   $pharmacy->branches()->first();
        $branches           =   $pharmacy->branches()->where('id', '<>', $firstBranch['id'])->get();
        $permits            =   $pharmacy->permits()->orderBy('created_at', 'DESC')->get();
        $countries          =   Country::all();
        $i                  =   0;

        $this->data = [
            'pharmacy'      =>  $pharmacy,
            'firstBranch'   =>  $firstBranch,
            'branches'      =>  $branches,
            'permits'       =>  $permits,
            'countries'     =>  $countries,
            'i'             =>  $i
        ];
        return view('providers_dashboards.pharmacy.profile.index')->with($this->data);
    }

    public function permitStore(PermitRequest $request)
    {
        $pharmacy                   = authUser('pharmacy');
        $msg                        = __('store.Congratulations!') . ' ' . __('translation.The qualification has been added successfully');
        $pharmacy->permits()->create($request->validated());

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=> route('pharmacy.profile')]);
    }

    public function permitUpdate(PermitUpdateRequest $request)
    {
        $pharmacy                   = authUser('pharmacy');
        $pharmacy->update($request->validated());
        $msg = __('translation.The data has been modified successfully');
        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('pharmacy.profile')]);
    }

    public function permitDelete(Request $request)
    {
        $pharmacy                   = authUser('pharmacy');
        $msg                        =  __('store.Congratulations!') . ' ' .  __('translation.The qualification has been deleted successfully');
        $pharmacy->permits()->findOrFail($request->id)->delete();

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('pharmacy.profile')]);
    }

    public function profileUpdate(ProfileRequest $request)
    {
        $requestValid           =   $request->validated();
        $pharmacy               =   authUser('pharmacy');
        $oldPhone               =   $pharmacy->phone;
        $oldCountryCode         =   $pharmacy->country_code;

        $pharmacy->update($requestValid);

        if ($oldPhone != $requestValid['phone'] || $oldCountryCode != $requestValid['country_code']){
            $pharmacy->sendPhoneActivationCode();
            $pharmacy->update(['is_active'=>0]);
        }

        $msg =  __('store.Congratulations!') . ' ' . __('store.Profile modified successfully');

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('pharmacy.profile')]);
    }

    public function pharmacyUpdate(UpdateStoreRequest $request)
    {
        $requestValidated= $request->validated();

        if ($this->checkTimes($request) == 'false'){
            $msg = __('store.Error in working hours');
            return response()->json(['key'=>'fail', 'msg'=>$msg]);
        }


        $pharmacy               =   authUser('pharmacy');
        $firstBranch            =   $pharmacy->branches()->first();
        $pharmacy->branches()->where('id', '<>', $firstBranch['id'])->whereNotIn('id', $requestValidated['ids'])->delete();

        foreach ($request['index'] as $i){
            $data = [
                'name'                          =>  $request['name'][$i],
                'lat'                           =>  $request['lat'][$i],
                'lng'                           =>  $request['lng'][$i],
                'address'                       =>  $request['address'][$i],
                'address_map'                   =>  $request['address_map'][$i],
                'comerical_record'              =>  $request['comerical_record'][$i],
            ];

            if ($request['ids'][$i] != 0  && $request['images-' . $i][0] == null && !isset($request['imagesIds-' . $i])){
                $msg = __('store.msg_error_delete_images');
                return response()->json(['key'=>'fail', 'msg'=>$msg]);
            }

            $branch = $pharmacy->branches()->updateOrCreate(['id'=>$requestValidated['ids'][$i]], $data);
            $times  = [];
            $images = [];

            foreach ($request['times']['days-' . $i] as $key => $value){

                $times[] = [
                    'pharmacy_branch_id'    =>  $branch['id'],
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
                        'pharmacy_branch_id'    =>  $branch['id'],
                        'image'                 => $this->uploadeImage($image, 'pharmacyimages'),
                        'created_at'            =>  Carbon::now(),
                        'updated_at'            =>  Carbon::now(),
                    ];
                }
            }

            $branch->dates()->delete();
            $imagesIds = !isset($request['imagesIds-' . $i]) ? [] : $request['imagesIds-' . $i];
            $branch->images()->whereNotIn('id', $imagesIds)->delete();

            PharmacyDate::insert($times);
            PharmacyBranchImage::insert($images);

        }

        $msg = __('store.Congratulations!'). ' ' . __('store.The lab has been modified successfully');
        return response()->json(['status'=>'success', 'url'=>route('pharmacy.profile'), 'msg'=>$msg]);
    }

    public function pharmacyDelete(Request $request)
    {
        if ($request->ajax()){
            $pharmacy    =   authUser('pharmacy');
            $url    =   route('pharmacy.showLogin');
            $msg    =   __('store.Congratulations!') . ' ' . __('store.Your account has been deleted successfully');
            $pharmacy->delete();
            Auth::guard('pharmacy')->logout();
            return response()->json(['status'=>'success', 'url'=>$url, 'msg'=>$msg]);
        }
    }
}
