<?php
namespace App\Services;

use Illuminate\Support\Facades\Route;

class ProviderRuleService {
    public static function getCreateProviderPermissions(string $providerType) {
        $routes      = Route::getRoutes();
        $permissions = [];

        foreach ($routes as $route) {

            if ($routeName = $route->getName()) {

                $routeNameAsArray = explode('.', $route->getName());

                if ($routeNameAsArray[0] == $providerType && in_array('App\Http\Middleware\ProviderCheckPermissionMiddleware', Route::gatherRouteMiddleware($route))) {

                    $permissions[] = $routeName;

                }

            }
        }
        return $permissions;
    }

    public static function redirectFirstAlloweRoute($providerType) {
        $myPermissions = auth($providerType)->user()->roles->pluck('permission')->toArray();

        $routes = Route::getRoutes();

        $firsAllowed = $providerType . '.site';

        if (count($myPermissions) == 0) {
            $firsAllowed = $providerType . '.home';
        }

        foreach ($routes as $route) {
            if ($routeName = $route->getName()) {

                $routeNameAsArray = explode('.', $routeName);

                if (
                    $route->methods()[0] == 'GET'
                    &&
                    $routeNameAsArray[0] == $providerType
                    &&
                    in_array('App\Http\Middleware\ProviderCheckPermissionMiddleware', Route::gatherRouteMiddleware($route))
                    &&
                    in_array($routeName, $myPermissions)
                ) {
                    $firsAllowed = $routeName;
                    break;
                }

            }
        }

        return redirect()->route($firsAllowed);
    }
}
