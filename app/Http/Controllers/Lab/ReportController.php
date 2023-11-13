<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller {

    public function finished() {
        if (request()->ajax()) {
            $reservations = Reservation::where(['lab_id' => provider('lab')->id, 'status' => 'finished'])->search(request()->searchArray)->paginate(30);
            $html         = view('providers_dashboards.lab.reports.reservations.table', compact('reservations'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.lab.reports.reservations.finished');
    }

    public function reservationDetails($id) {
        $reservation = Reservation::with('user', 'doctor', 'labSubCategories', 'labSubCategories.labSubCategory')->findOrFail($id);
        return view('providers_dashboards.lab.reports.reservations.details.index', get_defined_vars());
    }

    public function income() {
        if (request()->ajax()) {
            $reservations = Reservation::where(['lab_id' => provider('lab')->id, 'status' => 'finished'])
                ->when(request()->searchArray && !request()->searchArray['in_month'], function ($query) {
                    $query->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month);
                })
                ->search(request()->searchArray)->paginate(30);

            $month             = request()->searchArray['in_month'] ?? Carbon::now()->month;
            $income            = $reservations->sum('total_price');
            $reservationsCount = $reservations->count();
            $html              = view('providers_dashboards.lab.reports.income_body', compact('income', 'reservationsCount', 'month'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.lab.reports.income');
    }

    public function ordersPendingPayment() {
        if (request()->ajax()) {
            $orders = provider('lab')->orders()->with('store', 'store.branches')->where(['payment_status' => 'pending'])->search(request()->searchArray)->paginate(30);
            $html   = view('providers_dashboards.lab.reports.orders.table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.lab.reports.orders.pending_payment');
    }

    public function ordersPaid() {
        if (request()->ajax()) {
            $orders = provider('lab')->orders()->with('store', 'store.branches')->where(['payment_status' => 'paid'])->search(request()->searchArray)->paginate(30);
            $html   = view('providers_dashboards.lab.reports.orders.table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.lab.reports.orders.paid');
    }

    public function orderDetails($id) {
        $order = provider('lab')->orders()->with('lab', 'orderproducts', 'orderproducts.offer', 'orderproducts.product', 'installments')->findOrFail($id);
        return view('providers_dashboards.lab.reports.orders.details', compact('order'));
    }
}
