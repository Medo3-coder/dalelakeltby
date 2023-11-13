<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;

class ReportController extends Controller {

    public function ordersPendingPayment() {
        if (request()->ajax()) {
            $orders = provider('pharmacy')->orders()->with('store', 'store.branches')->where(['payment_status' => 'pending'])->search(request()->searchArray)->paginate(30);
            $html   = view('providers_dashboards.pharmacy.reports.orders.table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.pharmacy.reports.orders.pending_payment');
    }

    public function ordersPaid() {
        if (request()->ajax()) {
            $orders = provider('pharmacy')->orders()->with('store', 'store.branches')->where(['payment_status' => 'paid'])->search(request()->searchArray)->paginate(30);
            $html   = view('providers_dashboards.lab.reports.orders.table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.pharmacy.reports.orders.paid');
    }

    public function orderDetails($id) {
        $order = provider('pharmacy')->orders()->with('pharmacy', 'orderproducts', 'orderproducts.offer', 'orderproducts.product', 'installments')->findOrFail($id);
        return view('providers_dashboards.pharmacy.reports.orders.details', compact('order'));
    }
}
