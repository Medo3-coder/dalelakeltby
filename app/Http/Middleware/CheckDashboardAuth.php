<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDashboardAuth {
    public function handle(Request $request, Closure $next) {
        if (auth(request()->segment(1))->check()) {

            if (auth(request()->segment(1))->user()->is_blocked == 1) {
                auth(request()->segment(1))->logout();
                return redirect()->route(request()->segment(1) . '.login')->with(['error' => __('site.blocked')]);
            }elseif (auth(request()->segment(1))->user()->is_active == 0) {
                auth(request()->segment(1))->logout();
                return redirect()->route(request()->segment(1) . '.login')->with(['error' => __('site.need_active')]);
            }

            if (auth(request()->segment(1))->user()->is_active == 0) {
                auth(request()->segment(1))->logout();
                return redirect()->route(request()->segment(1) . '.login')->with(['error' => __('store.The mobile number must be activated')]);
            }

            return $next($request);
        } else {
            return redirect()->route(request()->segment(1) . '.login');
        }
    }
}
