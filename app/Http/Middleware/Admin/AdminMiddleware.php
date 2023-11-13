<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware {
  public function handle($request, Closure $next) {
    if (!Auth::guard('admin')->check()
      || !Auth::guard('admin')->user()->role_id > 0 || Auth::guard('admin')->user()->is_blocked == 1 ) {
        auth('admin')->logout();
      return redirect()->route('admin.login');
    }

    return $next($request);
  }
}
