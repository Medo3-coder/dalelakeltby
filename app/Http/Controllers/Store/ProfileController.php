<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Profile\PermitRequest;
use App\Http\Requests\Store\Profile\ProfileRequest;
use App\Http\Requests\Store\Profile\UpdateStoreRequest;
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
        $store              =   authUser('store');
        $firstBranch        =   $store->branches()->first();
        $branches           =   $store->branches()->where('id', '<>', $firstBranch['id'])->get();
        $permits            =   $store->permits()->orderBy('created_at', 'DESC')->get();
        $countries          =   Country::all();
        $i                  =   0;

        $this->data = [
            'store'         =>  $store,
            'firstBranch'   =>  $firstBranch,
            'branches'      =>  $branches,
            'permits'       =>  $permits,
            'countries'     =>  $countries,
            'i'             =>  $i
        ];
        return view('providers_dashboards.store.profile.index')->with($this->data);
    }

    public function permitStore(PermitRequest $request)
    {
        $store              = authUser('store');
        $msg                = __('store.Congratulations!') . ' ' . __('store.Permit saved successfully');
        $store->permits()->create($request->validated());

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=> route('store.profile')]);
    }

    public function permitDelete(Request $request)
    {
        $store              = authUser('store');
        $msg                =  __('store.Congratulations!') . ' ' .  __('store.The permit has been successfully deleted');
        $store->permits()->findOrFail($request->id)->delete();

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('store.profile')]);
    }

    public function profileUpdate(ProfileRequest $request)
    {
        $requestValid       =   $request->validated();
        $store              =   authUser('store');
        $oldPhone           =   $store->phone;
        $oldCountryCode     =   $store->country_code;

        $store->update($requestValid);

        if ($oldPhone != $requestValid['phone'] || $oldCountryCode != $requestValid['country_code']){
            $store->update(['is_active'=>0]);
        }

        $msg =  __('store.Congratulations!') . ' ' . __('store.Profile modified successfully');

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('store.profile')]);
    }

    public function storeUpdate(UpdateStoreRequest $request)
    {
        $requestValidated= $request->validated();

        if ($this->checkTimes($request) == 'false'){
            $msg = __('store.Error in working hours');
            return response()->json(['key'=>'fail', 'msg'=>$msg]);
        }


        $store              =   authUser('store');
        $firstBranch        =   $store->branches()->first();
        $store->branches()->where('id', '<>', $firstBranch['id'])->whereNotIn('id', $requestValidated['ids'])->delete();

        foreach ($request['index'] as $i){
            $data = [
                'name'                          =>  $request['name'][$i],
                'lat'                           =>  $request['lat'][$i],
                'lng'                           =>  $request['lng'][$i],
                'address'                       =>  $request['address'][$i],
                'address_map'                       =>  $request['address_map'][$i],
                'comerical_record'              =>  $request['comerical_record'][$i]
            ];

            if ($request['ids'][$i] != 0  && $request['images-' . $i][0] == null && !isset($request['imagesIds-' . $i])){
                $msg = __('store.msg_error_delete_images');
                return response()->json(['key'=>'fail', 'msg'=>$msg]);
            }

            $branch = $store->branches()->updateOrCreate(['id'=>$requestValidated['ids'][$i]], $data);
            $times  = [];
            $images = [];

            foreach ($request['times']['days-' . $i] as $key => $value){

                $times[] = [
                    'store_id'              =>  $store['id'],
                    'store_branch_id'              =>  $branch['id'],
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
                        'store_id'              =>  $store['id'],
                        'store_branch_id'              =>  $branch['id'],
                        'image'             => $this->uploadeImage($image, 'stores'),
                        'created_at'            =>  Carbon::now(),
                        'updated_at'            =>  Carbon::now(),
                    ];
                }
            }

            $branch->dates()->delete();
            $imagesIds = !isset($request['imagesIds-' . $i]) ? [] : $request['imagesIds-' . $i];
            $branch->images()->whereNotIn('id', $imagesIds)->delete();

            StoreDate::insert($times);
            StoreBranchImage::insert($images);

        }

        $msg = __('store.Congratulations!'). ' ' . __('store.The store has been modified successfully');
        return response()->json(['status'=>'success', 'url'=>route('store.profile'), 'msg'=>$msg]);
    }

    public function storeDelete(Request $request)
    {
        if ($request->ajax()){
            $store  =   authUser('store');
            $url    =   route('store.showLogin');
            $msg    =   __('store.Congratulations!') . ' ' . __('store.Your account has been deleted successfully');
            $store->delete();
            Auth::guard('store')->logout();
            return response()->json(['status'=>'success', 'url'=>$url, 'msg'=>$msg]);
        }
    }
}
