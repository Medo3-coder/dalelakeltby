<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace     = 'App\Http\Controllers';
    protected $siteNamespace = 'App\Http\Controllers\Site';

    protected $doctorNamespace   = 'App\Http\Controllers\Doctor';
    protected $storeNamespace    = 'App\Http\Controllers\Store';
    protected $pharmacyNamespace = 'App\Http\Controllers\Pharmacy';
    protected $labNamespace      = 'App\Http\Controllers\Lab';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapWebSiteRoutes();

        $this->mapDoctorRoutes();
        $this->mapStoreRoutes();
        $this->mapPharmacyRoutes();
        $this->mapLabRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes() {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes() {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapWebSiteRoutes() {
        Route::middleware('web')
            ->namespace($this->siteNamespace)
            ->group(base_path('routes/site.php'));
    }

    protected function mapDoctorRoutes() {
        Route::middleware('web')
            ->namespace($this->doctorNamespace)
            ->group(base_path('routes/doctor.php'));
    }

    protected function mapStoreRoutes() {
        Route::middleware('web')
            ->namespace($this->storeNamespace)
            ->group(base_path('routes/store.php'));
    }

    protected function mapPharmacyRoutes() {
        Route::middleware('web')
            ->namespace($this->pharmacyNamespace)
            ->group(base_path('routes/pharmacy.php'));
    }

    protected function mapLabRoutes() {
        Route::middleware('web')
            ->namespace($this->labNamespace)
            ->group(base_path('routes/lab.php'));
    }

}
