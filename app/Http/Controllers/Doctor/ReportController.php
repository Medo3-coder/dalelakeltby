<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller {

    public function finished() {
        if (request()->ajax()) {
            $reservations = Reservation::where(['doctor_id' => provider('doctor')->id, 'status' => 'finished'])->search(request()->searchArray)->paginate(30);
            $html         = view('providers_dashboards.doctor.reports.table', compact('reservations'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.doctor.reports.finished');
    }

    public function canceled() {
        if (request()->ajax()) {
            $reservations = Reservation::where(['doctor_id' => provider('doctor')->id])->whereIn('status', ['rejected', 'canceled'])->search(request()->searchArray)->paginate(30);
            $html         = view('providers_dashboards.doctor.reports.table', compact('reservations'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.doctor.reports.canceled');
    }

    public function reservationDetails($id) {
        $reservation     = Reservation::where(['doctor_id' => provider('doctor')->id])->whereIn('status' ,['finished', 'rejected', 'canceled'])->findOrFail($id);
        $breadCrambRouts = [
            'doctor.reports.canceled' => __('doctor.canceld_orders'),
        ];
        return view('providers_dashboards.doctor.reports.details', compact('reservation', 'breadCrambRouts'));
    }

    public function income() {
        if (request()->ajax()) {
            $reservations = Reservation::where(['doctor_id' => provider('doctor')->id, 'status' => 'finished'])
                ->when(request()->searchArray && !request()->searchArray['in_month'], function ($query) {
                    $query->whereYear('created_at', Carbon::now()->year)
                        ->whereMonth('created_at', Carbon::now()->month);
                })
                ->search(request()->searchArray)->paginate(30);

            $month             = request()->searchArray['in_month'] ?? Carbon::now()->month;
            $income            = $reservations->sum('total_price');
            $reservationsCount = $reservations->count();
            $html              = view('providers_dashboards.doctor.reports.income_body', compact('income', 'reservationsCount', 'month'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.doctor.reports.income');
    }

}
