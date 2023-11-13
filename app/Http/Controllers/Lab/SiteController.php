<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\SearchRequest;
use App\Models\CancelReason;
use App\Models\Offer;
use App\Models\Reservation;
use Illuminate\Support\Carbon;

class SiteController extends Controller {
    public $unreadNotifications = [];

    public function home() {
        $cancelReasons = CancelReason::get();
        $openions      = Reservation::with('user')->where([
            'lab_id' => provider('lab')->id,
            'status' => 'finished',
        ])->where('comment', '!=', null)->orderBy('updated_at', 'desc')->take(6)->get();

        $latestOffers = Offer::valid()->with('store')->where('type', 'equipment')->orderBy('updated_at', 'desc')->take(6)->get();

        return view('providers_dashboards.lab.home.index', get_defined_vars());
    }

    public function notifications() {
        $notifications = provider('lab')->notifications;
        $notifications->each(function ($notification) {
            if ($notification->read_at == null) {
                $notification->update(['read_at' => Carbon::now()]);
                $this->unreadNotifications[] = $notification->id;
            }
        });
        $unreadNotifications = $this->unreadNotifications;
        return view('providers_dashboards.lab.notifications', compact('notifications', 'unreadNotifications'));
    }

    public function search(SearchRequest $request)
    {
        if ($request->ajax()){
            $validated      = $request->validated();
            $offers         = Offer::with('store')->where(['type' => 'equipment'])->whereDate('end_offer', '>', now())->whereFuzzy('name', $validated['search'])->get();
            $html           = view('providers_dashboards.lab.includes.html.search', compact('offers'))->render();
            return response()->json(['key'=>'success', 'html'=>$html]);
        }
    }
}
