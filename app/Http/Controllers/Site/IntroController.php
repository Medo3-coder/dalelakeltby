<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\sendMessageRequest;
use App\Models\IntroFqsCategory;
use App\Models\IntroHowWork;
use App\Models\IntroMessages;
use App\Models\IntroPartener;
use App\Models\IntroService;
use App\Models\IntroSlider;
use App\Models\IntroSocial;
use App\Models\SiteSetting;
use App\Services\SettingService;

class IntroController extends Controller {
    public function index() {
        view()->share([
            'services'      => IntroService::get(),
            'sliders'       => IntroSlider::get(),
            'fqsCategories' => IntroFqsCategory::get(),
            'parteners'     => IntroPartener::get(),
            'howWorks'      => IntroHowWork::get(),
            'socials'       => IntroSocial::get(),
            'settings'      => SettingService::appInformations(SiteSetting::pluck('value', 'key')),
        ]);
        return view('intro_site.index');
    }

    public function privacyPolicy() {
        view()->share([
            'socials'  => IntroSocial::get(),
            'settings' => SettingService::appInformations(SiteSetting::pluck('value', 'key')),
        ]);
        return view('intro_site.privacy');
    }

    public function sendMessage(sendMessageRequest $request) {
        IntroMessages::create($request->validated());
        return response()->json(['status' => 'done', 'message' => __('intro_site.message_sent')]);
    }

}
