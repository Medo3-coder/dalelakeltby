<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\SearchRequest;
use App\Notifications\NotifyAdmin;
use App\Services\ProviderRuleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class SiteController extends Controller
{

    public $unreadNotifications = [];
    private $data = [];
    public function auth()
    {

        return provider('store');
    }
    public function home()
    {
        $store = $this->auth();
        $products = $store->products()->where('category_type', 'medicine')->where('counter', '<>', 0)->orderBy('counter', 'DESC')->take(8)->get();
        $orders = $store->orders()->where('status', 'pending')->latest()->take(8)->get();
        $ordersCount = $store->orders()->count();
        $ordersPendingCount = $store->orders()->where('status', 'pending')->count();
        $ordersAcceptedCount = $store->orders()->where('status', 'accepted')->count();
        $ordersPreparedCount = $store->orders()->where('status', 'prepared')->count();
        $ordersRejectedCount = $store->orders()->where('status', 'rejected')->count();

        $this->data = [
            'store'     =>  $store,
            'products'  =>  $products,
            'orders'  =>  $orders,
            'i'         =>  1,
            'ordersCount'   =>  $ordersCount,
            'ordersPendingCount'    =>  $ordersPendingCount,
            'ordersAcceptedCount'   =>  $ordersAcceptedCount,
            'ordersPreparedCount'   =>  $ordersPreparedCount,
            'ordersRejectedCount'   =>  $ordersRejectedCount
        ];

        return view('providers_dashboards.store.home.index', $this->data);
    }

    public function notifications()
    {
        $notifications = provider('store')->notifications;
        $notifications->each(function ($notification) {
            if ($notification->read_at == null) {
                $notification->update(['read_at' => \Illuminate\Support\Carbon::now()]);
                $this->unreadNotifications[] = $notification->id;
            }
        });
        $unreadNotifications = $this->unreadNotifications;
        return view('providers_dashboards.store.notifications', compact('notifications', 'unreadNotifications'));

    }

    public function search(SearchRequest $request)
    {
        if ($request->ajax()){
            $validated      = $request->validated();
            $store          = $this->auth();
            $products       = $store->products()->whereFuzzy('name', $validated['search'])->orWhereFuzzy('desc', $validated['search'])->get();
            $html           = view('providers_dashboards.store.includes.html.search', compact('products'))->render();
            return response()->json(['key'=>'success', 'html'=>$html]);
        }
    }
}
