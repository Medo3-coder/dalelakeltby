<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\coupons\CouponStoreRequest;
use App\Http\Requests\Store\coupons\CouponUpdateStatusRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function auth()
    {
        return provider('store');
    }

    public function index()
    {
        Carbon::setLocale(app()->getLocale());
        if (request()->ajax()) {
            $store          = $this->auth();
            $coupons        = $store->coupons()->search(request()->searchArray)->paginate(10);
            $html           = view('providers_dashboards.store.coupons.table' ,compact('coupons'))->render() ;

            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.store.coupons.index');
    }

    public function create()
    {
        return view('providers_dashboards.store.coupons.create');
    }

    public function store(CouponStoreRequest $request)
    {
        $store          = $this->auth();

        $validated      = $request->validated();

        $coupon         = $store->coupons()->where('code', $validated['code'])->first();

        if ($coupon){
            $msg        = __('store.Excuse me') . ' ' . __('store.This coupon already exists');
            return response()->json(['status'=>'fail', 'msg'=>$msg]);

        }

        $store->coupons()->create($request->validated());

        $msg            = __('store.Congratulations!') . ' ' . __('store.The discount coupon has been added successfully');
        $url            = route('store.coupons');

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>$url]);
    }

    public function edit($id)
    {
        $store          = $this->auth();
        $coupon         = $store->coupons()->findOrFail($id);

        return view('providers_dashboards.store.coupons.edit', compact('store', 'coupon'));
    }

    public function update(CouponStoreRequest $request, $id)
    {
        $store          = $this->auth();
        $validated      = $request->validated();

        $coupon         = $store->coupons()->where('code', $validated['code'])->where('id', '<>', $id)->first();

        if ($coupon){
            $msg        = __('store.Excuse me') . ' ' . __('store.This coupon already exists');
            return response()->json(['status'=>'fail', 'msg'=>$msg]);

        }

        $store->coupons()->findOrFail($id)->update($validated);

        $msg            = __('store.Congratulations!') . ' ' . __('store.The discount coupon has been modified successfully');
        $url            = route('store.coupons');
        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>$url]);
    }

    public function changeStatusClosed(Request $request)
    {
        if ($request->ajax()){
            $store          = $this->auth();
            $coupon         = $store->coupons()->findOrFail($request->id);
            $msg            = __('store.Coupon status updated successfully');
            $coupon->update(['status'=>'closed']);
            return response()->json(['status'=>'success', 'msg'=>$msg]);
        }
    }

    public function changeStatusAvailable(CouponUpdateStatusRequest $request)
    {
        $store          = $this->auth();
        $validated      = $request->validated();
        $msg            = __('store.Congratulations!') . ' ' . __('store.Coupon status updated successfully');
        $store->coupons()->findOrFail($validated['id'])->update($validated+['status'=>'available']);

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('store.coupons')]);

    }

    public function delete(Request $request)
    {
        $store          = $this->auth();
        $msg            = __('store.Congratulations!') . ' ' . __('store.The discount coupon has been removed successfully');
        $store->coupons()->findOrFail($request->id)->delete();
        return response()->json(['status'=>'success', 'msg'=>$msg]);
    }
}
