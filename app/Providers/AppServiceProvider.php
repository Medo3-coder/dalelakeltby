<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\Social;
use App\Services\SettingService;
use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    protected $settings, $socials;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

    }

    public function boot() {
        Paginator::useBootstrap();

        Schema::defaultStringLength(191);

        try {
            $this->settings = Cache::rememberForever('settings', function () {
                return SettingService::appInformations(SiteSetting::pluck('value', 'key'));
            });

            $this->socials = Cache::rememberForever('socials', function () {
                return Social::get();
            });

        } catch (Exception $e) {
            echo 'App service provider error : ' . $e->getMessage();
        }

        view()->composer('*', function ($view) {
            $view->with(['settings' => $this->settings]);
        });

        view()->composer('providers_dashboards.*', function ($view) {
            $view->with(['socials' => $this->socials]);
        });

        // -------------- lang ---------------- \\
        app()->singleton('lang', function () {
            if (session()->has('lang')) {
                return session('lang');
            } else {
                return 'ar';
            }

        });
        // -------------- lang ---------------- \\
    }
}
