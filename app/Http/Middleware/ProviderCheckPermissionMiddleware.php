<?php

namespace App\Http\Middleware;

use App\Services\ProviderRuleService;
use Closure;
use Illuminate\Http\Request;

class ProviderCheckPermissionMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {

        if (auth(request()->segment(1))->user()->parent_id != null) {

            $myPermissions = auth(request()->segment(1))->user()->roles->pluck('permission')->toArray();

            if (!in_array(request()->route()->getName(), $myPermissions)) {

                if (request()->ajax()) {

                    return response()->json([
                        'status' => 'doctor.not_have_permission',
                        'msg'    => __('doctor.not_have_permission'),
                    ]);

                }

                return ProviderRuleService::redirectFirstAlloweRoute(request()->segment(1))->with([
                    'error' => __('doctor.not_have_permission'),
                ]);

            }

        }

        return $next($request);
    }
}
