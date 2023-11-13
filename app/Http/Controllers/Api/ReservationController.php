<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Reservation\RateReservationRequest;
use App\Http\Requests\Api\Reservation\SendReservationRequest;
use App\Http\Resources\Api\CancelReasonsResource;
use App\Http\Resources\Api\Reservation\ReservationCollection;
use App\Http\Resources\Api\Reservation\ReservationResource;
use App\Models\CancelReason;
use App\Models\Reservation;
use App\Notifications\UserRateProviderNotification;
use App\Services\ReservationService;
use App\Traits\PaginationTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller {
    use PaginationTrait;

    use ResponseTrait;

    public function sendReservation(SendReservationRequest $request) {
        $storeResponse = (new ReservationService())->store($request->validated());
        if ($storeResponse['key'] == 'fail') {
            return $this->failMsg($storeResponse['msg']);
        }
        return $this->response('success', __('apis.reservation_send'), [
            'reservations'                 => new ReservationResource($storeResponse['reservations']),
            'available_reservations_count' => $storeResponse['available_reservations_count'],
        ]);
    }

    public function newReservations() {
        $reservations = Reservation::where(['status' => 'new', 'user_id' => auth()->id()])->latest()->paginate(30);
        return $this->successData(new ReservationCollection($reservations));
    }
    public function approvedReservations() {
        $reservations = Reservation::whereIn('status', ['approved', 'on_progress', 'transfer_to_lab', 'lab_send_results'])->where(['user_id' => auth()->id()])->latest()->paginate(30);
        return $this->successData(new ReservationCollection($reservations));
    }

    public function finishedReservations() {
        $reservations = Reservation::where(['status' => 'finished', 'user_id' => auth()->id()])->latest()->paginate(30);
        return $this->successData(new ReservationCollection($reservations));
    }

    public function reservationDetails($id) {
        $reservation = Reservation::with('MedicalRecord', 'MedicalRecord.medicalRecordMedicans', 'MedicalRecord.medicalRecordMedicans.doctorMedicine')->findOrFail($id);
        if (auth()->id() != $reservation->user_id) {
            return $this->failMsg(__('auth.not_authorized'));
        }
        return $this->successData(new ReservationResource($reservation));
    }

    public function cancelReservation(Request $request) {
        $reservation = Reservation::findOrFail($request->id);

        if (auth()->id() != $reservation->user_id) {
            return $this->failMsg(__('auth.not_authorized'));
        }
        if ('new' != $reservation->status) {
            return $this->failMsg(__('apis.approved_order_before'));
        }
        $reservation->update(['status' => 'canceled', 'cancel_reason_id' => $request->cancel_reason_id]);
        return $this->successMsg(trans('apis.order_canceled'));
    }

    public function rateReservation(RateReservationRequest $request) {
        $reservation = Reservation::with('doctor', 'lab')->findOrFail($request->id);

        if (auth()->id() != $reservation->user_id) {
            return $this->failMsg(__('auth.not_authorized'));
        }

        $reservation->update(['rate' => $request->rate, 'comment' => $request->comment]);

        if ($reservation->doctor) {
            $doctor_reservations = $reservation->doctor->reservations()->where('rate', '!=', null)->orWhere('comment', '!=', null);

            $reservation->doctor->update([
                'average_rate' => $doctor_reservations->avg('rate'),
                'count_rate'   => $doctor_reservations->count(),
            ]);
        } elseif ($reservation->lab) {
            $lab_reservations = $reservation->lab->reservations()->where('rate', '!=', null)->orWhere('comment', '!=', null);

            $reservation->lab->update([
                'average_rate' => $lab_reservations->avg('rate'),
                'count_rate'   => $lab_reservations->count(),
            ]);
        }

        if ($reservation->type == 'doctor') {
            Notification::send($reservation->doctor, new UserRateProviderNotification(route('doctor.opinions.index')));
        } else {
            Notification::send($reservation->lab, new UserRateProviderNotification(route('lab.home')));
        }

        return $this->successMsg(trans('apis.order_rated'));
    }

    public function cancelReasons() {
        return $this->successData(CancelReasonsResource::collection(CancelReason::get()));
    }
}
