<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pharmacy\Order\MakeOrderRequest;
use App\Models\Store;
use App\Notifications\ProviderCancelOrderNotification;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller {

    public function make(MakeOrderRequest $request) {
        return OrderService::makeOrder($request->validated(), provider('pharmacy'));
    }

    public function pending(Request $request) {
        if (request()->ajax()) {
            $orders = provider('pharmacy')->orders()->where('status' ,'pending')->with('store')->search(request()->searchArray)->paginate(30);
            $html   = view('providers_dashboards.pharmacy.orders.table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.pharmacy.orders.pending');
    }

    public function accepted(Request $request) {
        if (request()->ajax()) {
            $orders = provider('pharmacy')->orders()->where('status' ,'accepted')->with('store')->search(request()->searchArray)->paginate(30);
            $html   = view('providers_dashboards.pharmacy.orders.table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.pharmacy.orders.accepted');
    }

    public function prepared(Request $request) {
        if (request()->ajax()) {
            $orders = provider('pharmacy')->orders()->where('status' ,'prepared')->with('store')->search(request()->searchArray)->paginate(30);
            $html   = view('providers_dashboards.pharmacy.orders.table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.pharmacy.orders.prepared');
    }

    public function rejected(Request $request) {
        if (request()->ajax()) {
            $orders = provider('pharmacy')->orders()->whereIn('status' ,['canceled' ,'rejected'])->with('store')->search(request()->searchArray)->paginate(30);
            $html   = view('providers_dashboards.pharmacy.orders.table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.pharmacy.orders.rejected');
    }

    public function details($id) {
        Carbon::setLocale(app()->getLocale());
        $order = provider('pharmacy')->orders()->with('lab', 'orderproducts', 'orderproducts.offer', 'orderproducts.product', 'installments')->findOrFail($id);
        $store = $order->store;
        $orderGroups        =   $order->orderproducts()->orderBy('offer_id', 'DESC')->get();
        return view('providers_dashboards.pharmacy.orders.details', compact('order', 'store', 'orderGroups'));
    }

    public function cancel($order_id) {
        $order = provider('pharmacy')->orders()->where('status', 'pending')->findOrFail($order_id);
        $order->coupon()->delete();
        $order->update([
            'status' => 'canceled',
        ]);

        Notification::send($order->store, new ProviderCancelOrderNotification($order->order_num, route('store.orders.show', $order->id)));
        return response()->json([
            'status' => 'success',
            'url'    => url()->previous(),
        ]);
    }

    public function deleteProduct(Request $request)
    {
        if ($request->ajax()){
            $provider = provider('pharmacy');
            $cart    = $provider->carts()->findOrFail($request->id);

            $cart->delete();
            $msg = __('translation.msg_delete_product');
            return response()->json(['status'=>'success', 'msg'=>$msg]);
        }

    }

}
