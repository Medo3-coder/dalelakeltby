<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Traits\Menu;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\UpdateProfile;
use App\Http\Requests\Admin\Auth\updatePassword;
use Hash ;
class HomeController extends Controller
{
    use Menu ;
    /***************** dashboard *****************/
    public function dashboard()
    {
        $countryArray   = $this->chartData(new Country);
        $cityArray      = $this->chartData(new City);
        $menus          = $this->home() ;
        $introSiteCards = $this->introSiteCards() ;
        $colores        = ['info' , 'danger' , 'warning' , 'success' , 'primary'];
        
        return view('admin.dashboard.index' , compact('menus' ,'colores'  ,'countryArray' , 'cityArray' , 'introSiteCards' ));
    }

    public function profile() {
        return view('admin.admins.profile');
    }

    
    public function updateProfile(UpdateProfile $request) {
        auth('admin')->user()->update($request->validated());
        return back()->with('success' , __('admin.update_successfullay'));
    }
    
    public function updatePassword(updatePassword $request) {
        if (!Hash::check($request->old_password , auth('admin')->user()->password)) {
            return back()->with('danger' , __('admin.not_old_password'));
        }
        auth('admin')->user()->update(['password' => $request->password]);
        return back()->with('success' , __('admin.update_successfullay'));
    }




    public function chartData($model)
    {
        $users = $model::select('id', 'created_at')
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->format('Y-m'); 
        });
        $usermcount = [];
        $userArr = [];

        foreach ($users as $key => $value) {
            $usermcount[$key] = count($value);
        }
        for($i = 1; $i <= 12; $i++){
            $d = ($i < 10 )? date('Y').'-0'.$i : date('Y').'-'.$i;
            if(!empty($usermcount[$d])){
                $userArr[] = $usermcount[$d];
            }else{
                $userArr[] = 0;
            }
        }
        return $userArr ; 

    }
}
