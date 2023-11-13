<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lab\Reservation\SetReservationFirstResultRequest;
use App\Http\Requests\Lab\Reservation\UpdateReservationResultRequest;
use App\Models\CancelReason;
use App\Models\Reservation;
use App\Models\ReservationImage;
use App\Notifications\DoctorAcceptOrderNotification;
use App\Notifications\DoctorFinishReservationNotification;
use App\Notifications\DoctorRefuseOrderNotification;
use App\Notifications\PatientEnterToDoctorNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller {
    public function newReservations() {
        if (request()->ajax()) {
            $reservations = Reservation::where(['lab_id' => auth('lab')->id(), 'status' => 'new'])->search(request()->searchArray)->paginate(30);
            $html         = view('providers_dashboards.lab.reservations.table', compact('reservations'))->render();
            return response()->json(['html' => $html]);
        }
        $cancelReasons = CancelReason::get();
        return view('providers_dashboards.lab.reservations.new', compact('cancelReasons'));

    }
    public function acceptedReservations() {
        if (request()->ajax()) {
            $reservations = Reservation::where(['lab_id' => auth('lab')->id()])->whereIn('status', ['on_progress', 'approved', 'transfer_to_lab'])->search(request()->searchArray)->paginate(30);
            $html         = view('providers_dashboards.lab.reservations.accepted_table', compact('reservations'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.lab.reservations.accepted');

    }

    public function refuseReservation(Request $request) {
        $reservation = Reservation::with('user')->findOrFail($request->reservation_id);
        if ($reservation->lab_id != auth('lab')->id()) {
            return response()->json(['status' => 'fail', 'msg' => __('auth.not_authorized')]);
        }

        $reservation->update(['status' => 'rejected', 'cancel_reason_id' => $request->cancel_reason_id]);
        Notification::send($reservation->user, new DoctorRefuseOrderNotification($request->reservation_id));
        return response()->json(['status' => 'success']);
    }

    public function acceptReservation($reservation_id) {
        $reservation = Reservation::with('user')->findOrFail($reservation_id);
        if ($reservation->lab_id != auth('lab')->id()) {
            return response()->json(['status' => 'fail', 'msg' => __('auth.not_authorized')]);
        }
        $reservation->update(['status' => 'approved']);

        if ($reservation->user) {
            Notification::send($reservation->user, new DoctorAcceptOrderNotification($reservation_id));
        }

        return response()->json(['status' => 'success']);
    }

    public function reservationDetails($id) {
        $cancelReasons = CancelReason::get();
        $reservation   = Reservation::with('user', 'doctor', 'labSubCategories', 'labSubCategories.labSubCategory')->findOrFail($id);
        return view('providers_dashboards.lab.reservations.details.index', get_defined_vars());
    }

    public function patientEnter($reservation_id) {
        $reservation = Reservation::with('user')->findOrFail($reservation_id);
        $reservation->update(['status' => 'on_progress']);
        Notification::send($reservation->user, new PatientEnterToDoctorNotification($reservation_id));
        return response()->json(['status' => 'success']);
    }

    public function addReservationResult($reservation_id) {
        $reservation = Reservation::with('user', 'labSubcategoryReservationHasMany', 'labSubcategoryReservationHasMany.SubCategoryLab', 'labSubcategoryReservationHasMany.SubCategoryLab.labSubCategory')->where([
            'lab_id' => auth('lab')->id(),
            'id'     => $reservation_id,
        ])->firstOrFail();
        return view('providers_dashboards.lab.reservations.add_result', compact('reservation'));
    }

    public function setReservationFirstResult(SetReservationFirstResultRequest $request) {
        DB::beginTransaction();
        try {

            $reservation = Reservation::with('labSubcategoryReservationHasMany')->where([
                'lab_id' => auth('lab')->id(),
                'id'     => $request->reservation_id,
                'status' => 'on_progress',
            ])->firstOrFail();

            foreach ($request->validated()['lap_results'] as $result) {
                $reservation->labSubcategoryReservationHasMany->find($result['Lab_subcategory_reservation_id'])->update([
                    'result' => $result['result'],
                ]);
            }

            $images = [];
            if(isset($request->validated()['images'])){
                foreach ($request->validated()['images'] as $image) {
                    $images[] = new ReservationImage(['image' => $image]);
                }
                $reservation->images()->saveMany($images);
            }

            $reservation->update([
                'lab_report' => $request->validated()['lab_report'],
            ]);

            DB::commit();

            return response()->json(['status' => 'success', 'msg' => __('apis.added')]);
        } catch (Exception $e) {
            DB::rollBack();
            info('lab ReservationController error at setReservationFirstResult function : ' . $e->getMessage());
        }
    }

    public function updateReservationResult(UpdateReservationResultRequest $request) {
        DB::beginTransaction();
        try {

            $reservation = Reservation::with('labSubcategoryReservationHasMany')->where([
                'lab_id' => auth('lab')->id(),
                'id'     => $request->reservation_id,
                'status' => 'on_progress',
            ])->firstOrFail();

            foreach ($request->validated()['lap_results'] as $result) {
                $reservation->labSubcategoryReservationHasMany->find($result['Lab_subcategory_reservation_id'])->update([
                    'result' => $result['result'],
                ]);
            }

            if (isset($request->validated()['images'])) {
                $images = [];
                foreach ($request->validated()['images'] as $image) {
                    $images[] = new ReservationImage(['image' => $image]);
                }
                $reservation->images()->saveMany($images);
            }
            $reservation->update([
                'lab_report' => $request->validated()['lab_report'],
            ]);

            if (isset($request->validated()['deleted_images'])) {
                $reservation->images()->whereIn('id', $request->validated()['deleted_images'])->get()->each->delete();
            }

            DB::commit();

            return response()->json(['status' => 'success', 'msg' => __('apis.added'), 'url' => route('lab.reservationDetails', $request->reservation_id)]);
        } catch (Exception $e) {
            DB::rollBack();
            info('lab ReservationController error at updateReservationResult function : ' . $e->getMessage());
        }
    }

    public function finishReservation($reservation_id) {
        $reservation = Reservation::with('user', 'parent')->where([
            'lab_id' => auth('lab')->id(),
            'status' => 'on_progress',
        ])->findOrFail($reservation_id);
        $reservation->update([
            'status' => 'finished',
        ]);

        if ($parent = $reservation->parent) {
            $parent->update([
                'status' => 'lab_send_results',
            ]);
        }

        Notification::send($reservation->user, new DoctorFinishReservationNotification($reservation_id));

        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.success'),
            'url'    => route('lab.acceptedReservations'),
        ]);
    }
}
