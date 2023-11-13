<?php

namespace App\Http\Middleware;

use App\Services\ProviderRuleService;
use App\Traits\AdminFirstRouteTrait;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RedirectIfAuthenticated {
    use AdminFirstRouteTrait;
    public function handle($request, Closure $next, $guard = null) {
        if (Auth::guard($guard)->check()) {

            if ('admin' == $guard) {
                return redirect()->route($this->getAdminFirstRouteName());
            } elseif ($guard == 'doctor') {
                return ProviderRuleService::redirectFirstAlloweRoute('doctor');
            } elseif ($guard == 'lab') {
                return ProviderRuleService::redirectFirstAlloweRoute('lab');
            } elseif ($guard == 'store') {
                return ProviderRuleService::redirectFirstAlloweRoute('store');
            } elseif ($guard == 'pharmacy') {
                return ProviderRuleService::redirectFirstAlloweRoute('pharmacy');
            } else {
                return redirect()->route('intro');
            }
        }

        return $next($request);
    }
}
