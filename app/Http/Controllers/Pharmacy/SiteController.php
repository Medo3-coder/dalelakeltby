<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Store;
use Carbon\Carbon;

class SiteController extends Controller {
    public $unreadNotifications = [];

    public function home() {
        $offers   = Offer::valid()->orderBy('created_at', 'desc')->take(5)->get();
        $products = Product::popular('medicine')->take(5)->get();

        $stores = Store::popular()->take(3)->get();

        return view('providers_dashboards.pharmacy.home.index', get_defined_vars());
    }

    public function notifications() {
        $notifications = provider('pharmacy')->notifications;
        $notifications->each(function ($notification) {
            if ($notification->read_at == null) {
                $notification->update(['read_at' => Carbon::now()]);
                $this->unreadNotifications[] = $notification->id;
            }
        });
        $unreadNotifications = $this->unreadNotifications;
        return view('providers_dashboards.pharmacy.notifications', compact('notifications', 'unreadNotifications'));
    }
}
