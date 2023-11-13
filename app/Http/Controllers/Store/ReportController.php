<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\StatusRejectedRequest;
use App\Models\Order;
use App\Models\OrderInstallment;
use App\Notifications\StorePaidOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    private $data = [];
    public function auth()
    {
        return provider('store');
    }

    public function index()
    {

    }

    public function beingPaid()
    {
        $status =   \request()->segment(4);
        $msg    = $status == 'being-paid' ? __('store.orders-being-paid') : __('store.orders-paid');
        Carbon::setLocale(app()->getLocale());
        if (request()->ajax()) {
            $store          = $this->auth();
            $orders         = $store->orders()->whereHas('installments')->where(['payment_type'=>'installment','payment_status'=> 'pending', 'status'=>'prepared'])->search(request()->searchArray)->paginate(10);
            $html           = view('providers_dashboards.store.reports.table' ,compact('orders'))->render() ;

            return response()->json(['html' => $html]);
        }

        return view('providers_dashboards.store.reports.index', compact('msg', 'status'));
    }

    public function paid()
    {
        $status =   \request()->segment(4);
        $msg    =  __('store.orders-paid');
        Carbon::setLocale(app()->getLocale());
        if (request()->ajax()) {
            $store          = $this->auth();
            $orders         = $store->orders()->whereHas('installments')->where(['payment_type'=>'installment','payment_status'=> 'paid', 'status'=>'prepared'])->search(request()->searchArray)->paginate(10);
            $html           = view('providers_dashboards.store.reports.table' ,compact('orders'))->render() ;

            return response()->json(['html' => $html]);
        }

        return view('providers_dashboards.store.reports.index', compact('msg', 'status'));
    }

    public function month($request)
    {
        $store                                  =   $this->auth();
        $dateMonthArray                         =   explode('/', $request->value);
        $month                                  =   $dateMonthArray[0];
        $year                                   =   $dateMonthArray[1];
        $monthString                            =   Carbon::parse($year . '-' . $month . '-01')->translatedFormat('F');
        $string                                 =   __('store.month income', ['name'=>Carbon::parse($year . '-' . $month . '-01')->translatedFormat('F Y')]);
        $totalCash                              =   $store->orders()->where('status', 'prepared')->where(DB::raw('YEAR(created_at)'), '=', $year)->where(DB::raw('MONTH(created_at)'), '=', $month)->where('payment_type', 'cash')->sum('final_total');
        $totalOnline                            =   $store->orders()->where('status', 'prepared')->where(DB::raw('YEAR(created_at)'), '=', $year)->where(DB::raw('MONTH(created_at)'), '=', $month)->where('payment_type', 'online')->sum('final_total');
        $totalZain                              =   $store->orders()->where('status', 'prepared')->where(DB::raw('YEAR(created_at)'), '=', $year)->where(DB::raw('MONTH(created_at)'), '=', $month)->where(['payment_type'=> 'online', 'online_type'=>'zain'])->sum('final_total');
        $totalAsia                              =   $store->orders()->where('status', 'prepared')->where(DB::raw('YEAR(created_at)'), '=', $year)->where(DB::raw('MONTH(created_at)'), '=', $month)->where(['payment_type'=> 'online', 'online_type'=>'asia'])->sum('final_total');
        $totalMaster                            =   $store->orders()->where('status', 'prepared')->where(DB::raw('YEAR(created_at)'), '=', $year)->where(DB::raw('MONTH(created_at)'), '=', $month)->where(['payment_type'=> 'online', 'online_type'=>'master'])->sum('final_total');
        $totalVisa                              =   $store->orders()->where('status', 'prepared')->where(DB::raw('YEAR(created_at)'), '=', $year)->where(DB::raw('MONTH(created_at)'), '=', $month)->where(['payment_type'=> 'online', 'online_type'=>'visa'])->sum('final_total');
        $totalInstallment                       =   $store->orders()->where('status', 'prepared')->where(DB::raw('YEAR(created_at)'), '=', $year)->where(DB::raw('MONTH(created_at)'), '=', $month)->where(['payment_type'=> 'installment'])->sum('final_total');
        $totalInstallmentIds                    =   $store->orders()->where('status', 'prepared')->where(DB::raw('YEAR(created_at)'), '=', $year)->where(DB::raw('MONTH(created_at)'), '=', $month)->where(['payment_type'=> 'installment'])->pluck('id')->toArray();
        $totalInstallmentPending                =   OrderInstallment::whereIn('order_id', $totalInstallmentIds)->where('status','not_paid')->sum('amount');
        $totalInstallmentFinished               =   OrderInstallment::whereIn('order_id', $totalInstallmentIds)->where('status','paid')->sum('amount');
        $totalIncome                            =   $store->orders()->where('status', 'prepared')->where(DB::raw('YEAR(created_at)'), '=', $year)->where(DB::raw('MONTH(created_at)'), '=', $month)->sum('final_total');

       return  [
            'string'                            =>  $string,
            'totalCash'                         =>  $totalCash,
            'totalOnline'                       =>  $totalOnline,
            'totalZain'                         =>  $totalZain,
            'totalAsia'                         =>  $totalAsia,
            'totalMaster'                       =>  $totalMaster,
            'totalVisa'                         =>  $totalVisa,
            'totalInstallment'                  =>  $totalInstallment,
            'totalInstallmentPending'           =>  $totalInstallmentPending,
            'totalInstallmentFinished'          =>  $totalInstallmentFinished,
            'totalIncome'                       =>  $totalIncome
        ];
    }

    public function day($request)
    {

        $dateMonthArray                             =   explode('/', $request->value);
        $month                                      =   $dateMonthArray[0];
        $day                                        =   $dateMonthArray[1];
        $year                                       =   $dateMonthArray[2];
        $request->value = $day . '-' . $month . '-' . $year;
        $store                                      =   $this->auth();
        $string                                     =   __('store.day income') . ' ' . Carbon::parse($request->value)->translatedFormat('j F Y');
        $totalCash                                  =   $store->orders()->where('status', 'prepared')->whereDay('created_at', $request->value)->where('payment_type', 'cash')->sum('final_total');
        $totalOnline                                =   $store->orders()->where('status', 'prepared')->whereDay('created_at', $request->value)->where('payment_type', 'online')->sum('final_total');
        $totalZain                                  =   $store->orders()->where('status', 'prepared')->whereDay('created_at', $request->value)->where(['payment_type'=> 'online', 'online_type'=>'zain'])->sum('final_total');
        $totalAsia                                  =   $store->orders()->where('status', 'prepared')->whereDay('created_at', $request->value)->where(['payment_type'=> 'online', 'online_type'=>'asia'])->sum('final_total');
        $totalMaster                                =   $store->orders()->where('status', 'prepared')->whereDay('created_at', $request->value)->where(['payment_type'=> 'online', 'online_type'=>'master'])->sum('final_total');
        $totalVisa                                  =   $store->orders()->where('status', 'prepared')->whereDay('created_at', $request->value)->where(['payment_type'=> 'online', 'online_type'=>'visa'])->sum('final_total');
        $totalInstallment                           =   $store->orders()->where('status', 'prepared')->whereDay('created_at', $request->value)->where(['payment_type'=> 'installment'])->sum('final_total');
        $totalInstallmentIds                        =   $store->orders()->where('status', 'prepared')->whereDay('created_at', $request->value)->where(['payment_type'=> 'installment'])->pluck('id')->toArray();
        $totalInstallmentPending                    =   OrderInstallment::whereIn('order_id', $totalInstallmentIds)->whereDay('created_at', $request->value)->where('status','not_paid')->sum('amount');
        $totalInstallmentFinished                   =   OrderInstallment::whereIn('order_id', $totalInstallmentIds)->whereDay('created_at', $request->value)->where('status','paid')->sum('amount');
        $totalIncome                                =   $store->orders()->where('status', 'prepared')->whereDay('created_at', $request->value)->sum('final_total');

        return  [
            'string'                                =>  $string,
            'totalCash'                             =>  $totalCash,
            'totalOnline'                           =>  $totalOnline,
            'totalZain'                             =>  $totalZain,
            'totalAsia'                             =>  $totalAsia,
            'totalMaster'                           =>  $totalMaster,
            'totalVisa'                             =>  $totalVisa,
            'totalInstallment'                      =>  $totalInstallment,
            'totalInstallmentPending'               =>  $totalInstallmentPending,
            'totalInstallmentFinished'              =>  $totalInstallmentFinished,
            'totalIncome'                           =>  $totalIncome
        ];
    }

    public function income(Request $request)
    {

        if ($request->ajax()){

            if ($request->type == 'month'){
                $data = $this->month($request);
            }else{
                $data = $this->day($request);
            }
            $html           = view('providers_dashboards.store.reports.filter', compact('data'))->render() ;
            return response()->json(['status'=>'success', 'html'=>$html]);
        }

        return view('providers_dashboards.store.reports.income');

    }
    public function orderShow($id)
    {
        Carbon::setLocale(app()->getLocale());
        $store                      =   $this->auth();
        $order                      =   $store->orders()->findOrFail($id);
        $type                       =   getTypeUser($order);
        $user                       =   getUser($order);
        $branch                     =   getBranch($order);
        $orderGroups                =   $order->orderproducts()->orderBy('offer_id', 'DESC')->get();
        $installments               =   $order->installments;
        $installmentsPending        =   $installments->where('status', 'not_paid')->sum('amount');

        $this->data = [
            'store'                 =>  $store,
            'order'                 =>  $order,
            'type'                  =>  $type,
            'user'                  =>  $user,
            'branch'                =>  $branch,
            'orderGroups'           =>  $orderGroups,
            'installments'          =>  $installments,
            'installmentsPending'   =>  $installmentsPending
        ];
        return view('providers_dashboards.store.reports.show', $this->data);
    }

    public function statusPaid(StatusRejectedRequest $request, $id)
    {
        $store              =   $this->auth();
        $order              =   $store->orders()->findOrFail($request->id);
        $installment        =   $order->installments()->findOrFail($id);
        $user               =   getUser($order);
        $type               =   getTypeUser($order);
        $route              =   getRouteOrder($order, $type);
        $msg                =   __('store.paid_amount', ['amount'=>$installment->amount,'num'=>$order->order_num]);

        if ($order->installments()->where('status', 'not_paid')->count() == 1){

            $order->update(['payment_status'=>'paid']);
        }

        $installment->update(['status'=>'paid']);
        Notification::send($user, new StorePaidOrderNotification($order->order_num, $installment->amount, $route));

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('store.reports.show', $order->id)]);
    }


}
