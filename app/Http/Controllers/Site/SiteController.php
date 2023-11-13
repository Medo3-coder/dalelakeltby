<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AppPage;
use App\Models\Doctor;
use App\Models\Pharmacist;
use App\Models\SiteFeature;
use App\Models\Store;
use App\Models\User;

class SiteController extends Controller {
    public function index() {
        $features     = SiteFeature::get();
        $appPages     = AppPage::get();
        $usersCount   = User::count();
        $doctorsCount = Doctor::count();
        $binifitCount = $doctorsCount + $usersCount + Store::count() + Pharmacist::count();
        return view('providers_dashboards.master_website', get_defined_vars());
    }

    /***************** change lang  *****************/
    public function SetLanguage($lang) {
        if (in_array($lang, ['ar', 'en' ,'kur'])) {

            if (session()->has('lang')) {
                session()->forget('lang');
            }

            session()->put('lang', $lang);

        }
//        dd(session( 'lang' ));
        return back();
    }
}
