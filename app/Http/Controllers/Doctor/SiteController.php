<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\SearchRequest;
use App\Models\CancelReason;
use App\Models\DoctorMedicine;
use App\Models\MedicalRecordMedican;
use App\Models\Reservation;
use Carbon\Carbon;

class SiteController extends Controller {

    public $unreadNotifications = [];

    public function auth()
    {

        return provider('doctor');
    }
    public function home() {

        $reservations = Reservation::with('user')->where([
            'doctor_id' => provider('doctor')->id,
            'status'    => 'new',
        ]);

        if (request()->ajax()) {
            $html = view('providers_dashboards.doctor.home.table', ['reservations' => $reservations->get()])->render();
            return response()->json(['html' => $html]);
        }
        $newReservationsCount = $reservations->count();

        $cancelReasons = CancelReason::get();

        $finishedReservations = Reservation::with('user')->where([
            'doctor_id' => provider('doctor')->id,
            'status'    => 'finished',
        ]);

        $openions = $finishedReservations->orderBy('updated_at', 'desc')->take(6)->get();

        $mostUsedMedicines = MedicalRecordMedican::with('doctorMedicine')->whereHas('doctorMedicine', function ($medicine) {
            $medicine->where('doctor_id', provider('doctor')->id);
        })->select('doctor_medican_id')->selectRaw('COUNT(*) AS count')
            ->groupBy('doctor_medican_id')->orderByDesc('count')->limit(6)
            ->get()->toArray();

        $finishedReservationCount = $finishedReservations->count();
        $addedMedicinesCount      = DoctorMedicine::where('doctor_id', provider('doctor')->id)->count();
        return view('providers_dashboards.doctor.home.index', get_defined_vars());
    }

    public function notifications() {
        $notifications = provider('doctor')->notifications;
        $notifications->each(function ($notification) {
            if ($notification->read_at == null) {
                $notification->update(['read_at' => Carbon::now()]);
                $this->unreadNotifications[] = $notification->id;
            }
        });
        $unreadNotifications = $this->unreadNotifications;
        return view('providers_dashboards.doctor.notifications', compact('notifications', 'unreadNotifications'));
    }

    public function search(SearchRequest $request)
    {
        if ($request->ajax()){
            $validated      = $request->validated();
            $doctor         = $this->auth();
            $medicines      = $doctor->medicines()->whereFuzzy('name', $validated['search'])->orWhereFuzzy('type', $validated['search'])->get();
            $html           = view('providers_dashboards.doctor.includes.html.search', compact('medicines'))->render();
            return response()->json(['key'=>'success', 'html'=>$html]);
        }
    }
}
