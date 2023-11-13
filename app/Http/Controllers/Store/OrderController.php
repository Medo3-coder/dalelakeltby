<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StatusAcceptedRequest;
use App\Http\Requests\Store\StatusRejectedRequest;
use App\Models\Offer;
use App\Models\Order;
use App\Models\StoreCoupon;
use App\Notifications\StoreAcceptedOrderNotification;
use App\Notifications\StorePreparedOrderNotification;
use App\Notifications\StoreRejectedOrderNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{

    private $data = [];
    public function auth()
    {
        return provider('store');
    }

    public function index()
    {
        $status             = \request()->segment(3);
        $msg                = __('store.orders.' . $status);
        Carbon::setLocale(app()->getLocale());
        if (request()->ajax()) {
            $store          = $this->auth();
            $orders         = $store->orders()->where('status', $status)->search(request()->searchArray)->paginate(10);
            $html           = view('providers_dashboards.store.orders.table' ,compact('orders'))->render() ;

            return response()->json(['html' => $html]);
        }


        return view('providers_dashboards.store.orders.index', compact('msg', 'status'));
    }


    public function show($id)
    {
        Carbon::setLocale(app()->getLocale());
        $store              =   $this->auth();
        $order              =   $store->orders()->findOrFail($id);
        $type               =   $order->lab_id == null && $order->pharmacist_id != null ? 'pharmacy' : 'lab';
        $user               =   $order->lab_id == null && $order->pharmacist_id != null ? $order->pharmacy : $order->lab;
        $branch             =   $order->lab_branch_id == null && $order->pharmacist_id != null ? $order->pharmacyBranch : $order->labBranch;
        $orderGroups        =   $order->orderproducts()->orderBy('offer_id', 'DESC')->get();

        $this->data = [
            'store'         =>  $store,
            'order'         =>  $order,
            'type'          =>  $type,
            'user'          =>  $user,
            'branch'        =>  $branch,
            'orderGroups'   =>  $orderGroups,
        ];

        return view('providers_dashboards.store.orders.show', $this->data);
    }

    public function checkQty($order) {
        $store = provider('store');
        $orderProducts = $order->orderproducts;
        $status = true;
        if (count($orderProducts) > 0){
            foreach ($orderProducts as $orderProduct){
                if ($orderProduct->offer_id != null){
                    $offer          = $store->offers()->find($orderProduct->offer_id);
                    $productsIds    = $offer->products()->pluck('product_id')->toArray();
                    foreach ($store->products()->whereIn('id', $productsIds)->get() as $product){
                        if ($orderProduct->qty > $product->groupOne()->in_stock_qty){
                            $status = false;
                        }

                    }


                }

                if ($orderProduct->product_id != null){
                    if ($orderProduct->qty > $orderProduct->product()->first()->groupOne()->in_stock_qty){
                        $status = false;
                    }
                }
            }

        }
        return $status;
    }

    public function statusAccepted(StatusAcceptedRequest $request)
    {
        $store              =   $this->auth();
        $order              =   $store->orders()->findOrFail($request->id);
        $user               =   getUser($order);
        $type               =   getTypeUser($order);
        $route              =   getRouteOrder($order, $type);
        $msg                =   __('store.accepted_order', ['num'=>$order->order_num]);

        if ($this->checkQty($order) == false) {
            $msg = __('translation.error_qty');
            return response()->json(['status'=>'fail', 'msg'=>$msg]);
        }


        getProducts($order);
        $coupon             =   $store->coupons()->where('code', $order->coupon)->first();
        if ($coupon){
            $coupon->increment('use_times', 1);
        }


        Notification::send($user, new StoreAcceptedOrderNotification($order->order_num,$route));

        $order->update($request->validated() + ['status'=>'accepted']);

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('store.orders.show', $order->id)]);
    }

    public function statusRejected(StatusRejectedRequest $request)
    {
        $store              =   $this->auth();
        $order              =   $store->orders()->findOrFail($request->id);
        $user               =   getUser($order);
        $type               =   getTypeUser($order);
        $route              =   getRouteOrder($order, $type);
        $msg                =   __('store.rejected_order', ['num'=>$order->order_num]);
        $coupon             =   $store->coupons()->where('code', $order->coupon)->first();
        if ($coupon){
            $user->coupons()->where('store_coupon_id', $coupon->id)->delete();
        }
        $order->update($request->validated() + ['status'=>'rejected']);
        Notification::send($user, new StoreRejectedOrderNotification($order->order_num, $route));

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('store.orders.show', $order->id)]);
    }

    public function statusPrepared(StatusRejectedRequest $request)
    {
        $store              =   $this->auth();
        $order              =   $store->orders()->findOrFail($request->id);
        $user               =   getUser($order);
        $type               =   getTypeUser($order);
        $route              =   getRouteOrder($order, $type);
        $msg                =   __('store.prepared_order', ['num'=>$order->order_num]);

        $order->update($request->validated() + ['status'=>'prepared']);

        Notification::send($user, new StorePreparedOrderNotification($order->order_num, $route));

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('store.orders.show', $order->id)]);
    }
}
