<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Opinion\Store;
use App\Models\Admin;
use App\Models\Reservation;
use App\Notifications\NewReportRateNotification;
use Illuminate\Support\Facades\Notification;

class OpinionController extends Controller {

    public function index() {
        $reservations = Reservation::with('user')->where('doctor_id', provider('doctor')->id)
            ->where('status', 'finished')
            ->where('rate', '!=', null)
            ->where('comment', '!=', null)
            ->orderBy('created_at', 'desc')->paginate(30);
        return view('providers_dashboards.doctor.opinions.index', compact('reservations'));
    }

    public function report(Store $request) {
        $report = provider('doctor')->reports()->create($request->validated());

        Notification::send(Admin::get(), new NewReportRateNotification(route('admin.reportrates.show', $report->id)));

        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.complaint_send'),
        ]);
    }

}
