<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Reservation\AddNewRageteRequest;
use App\Http\Requests\Doctor\Reservation\SendPatientToLabRequest;
use App\Http\Requests\Doctor\Reservation\WriteRegeteRequest;
use App\Models\CancelReason;
use App\Models\categoriesLab;
use App\Models\ChranicDisease;
use App\Models\Lab;
use App\Models\LabCategory;
use App\Models\MedicalRecord;
use App\Models\Ragite;
use App\Models\Reservation;
use App\Models\SubCategoryLab;
use App\Notifications\DoctorAcceptOrderNotification;
use App\Notifications\DoctorFinishReservationNotification;
use App\Notifications\DoctorRefuseOrderNotification;
use App\Notifications\PatientEnterToDoctorNotification;
use App\Services\ReservationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller {
    public function newReservations() {
        if (request()->ajax()) {
            $reservations = Reservation::where(['doctor_id' => provider('doctor')->id, 'status' => 'new'])->search(request()->searchArray)->paginate(30);
            $html         = view('providers_dashboards.doctor.reservations.table', compact('reservations'))->render();
            return response()->json(['html' => $html]);
        }
        $cancelReasons = CancelReason::get();
        return view('providers_dashboards.doctor.reservations.new', compact('cancelReasons'));

    }
    public function acceptedReservations() {
        if (request()->ajax()) {
            $reservations = Reservation::where(['doctor_id' => provider('doctor')->id])->whereIn('status', ['on_progress', 'approved', 'transfer_to_lab', 'lab_send_results'])->search(request()->searchArray)->paginate(30);
            $html         = view('providers_dashboards.doctor.reservations.accepted_table', compact('reservations'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.doctor.reservations.accepted');

    }

    public function refuse(Request $request) {

        $reservation = Reservation::with('user')->findOrFail($request->reservation_id);

        if ($reservation->doctor_id != provider('doctor')->id) {
            return response()->json(['status' => 'fail', 'msg' => __('auth.not_authorized')]);
        }

        if ($reservation->status != 'new') {
            return response()->json(['status' => 'fail', 'msg' => __('provider.order_canceled_by_user')]);
        }

        $reservation->update(['status' => 'rejected', 'cancel_reason_id' => $request->cancel_reason_id]);

        Notification::send($reservation->user, new DoctorRefuseOrderNotification($reservation->id));

        return response()->json(['status' => 'success']);
    }

    public function accept($reservation_id) {

        $reservation = Reservation::with('user')->findOrFail($reservation_id);

        if ($reservation->doctor_id != provider('doctor')->id) {
            return response()->json(['status' => 'fail', 'msg' => __('auth.not_authorized')]);
        }

        if ($reservation->status != 'new') {
            return response()->json(['status' => 'fail', 'msg' => __('provider.order_canceled_by_user')]);
        }

        $reservation->update(['status' => 'approved']);

        Notification::send($reservation->user, new DoctorAcceptOrderNotification($reservation->id));

        return response()->json(['status' => 'success']);
    }

    public function reservationDetails(Request $request, $id) {
        $reservation = Reservation::with('user', 'children', 'children.lab', 'children.labSubcategoryReservationHasMany', 'children.labSubcategoryReservationHasMany.subCategoryLab', 'children.labSubcategoryReservationHasMany.subCategoryLab.labSubCategory', 'children.images', 'user.bloodType', 'patientBloodType', 'MedicalRecord', 'MedicalRecord.medicalRecordMedicans', 'MedicalRecord.medicalRecordMedicans.doctorMedicine')->findOrFail($id);

        $finishedReservationsPersonal = Reservation::with('images', 'user.bloodType', 'patientBloodType', 'MedicalRecord', 'MedicalRecord.medicalRecordMedicans', 'MedicalRecord.medicalRecordMedicans.doctorMedicine')->where(['user_id' => $reservation->user_id, 'status' => 'finished', 'reservation_for' => 'same_person'])->get();
        $finishedReservationsFamily   = Reservation::with('images', 'user.bloodType', 'patientBloodType', 'MedicalRecord', 'MedicalRecord.medicalRecordMedicans', 'MedicalRecord.medicalRecordMedicans.doctorMedicine')->where(['user_id' => $reservation->user_id, 'status' => 'finished', 'reservation_for' => 'family'])->get();

        if (isset($request->next_patient) && $request->next_patient == 1 && $reservation->status == 'approved') {
            $reservation->update(['status' => 'on_progress']);
            Notification::send($reservation->user, new PatientEnterToDoctorNotification($id));
        }

        $charnicDiseases = ChranicDisease::get();
        $ragites         = provider('doctor')->ragites;

        $nextReservationId = provider('doctor')->reservations()->where('status', 'approved')->first()?->id;

        return view('providers_dashboards.doctor.reservations.details.index', get_defined_vars());
    }

    public function patientEnter($reservation_id) {
        $reservation = Reservation::with('user')->findOrFail($reservation_id);
        $reservation->update(['status' => 'on_progress']);
        Notification::send($reservation->user, new PatientEnterToDoctorNotification($reservation_id));
        return response()->json(['status' => 'success']);
    }

    public function chooseLab($reservation_id) {
        $reservation    = Reservation::with('user')->findOrFail($reservation_id);
        $categoriesLabs = categoriesLab::with('labCategory', 'lab')->orderBy('lab_id')->paginate(30);
        return view('providers_dashboards.doctor.reservations.choose_lab', get_defined_vars());
    }

    public function labReservation(Request $request, $reservation_id) {
        $reservation      = Reservation::with('user')->where('doctor_id', provider('doctor')->id)->findOrFail($reservation_id);
        $lab              = Lab::with('branches', 'branches.images')->findOrFail($request->lab);
        $labCategory      = LabCategory::findOrFail($request->lab_category);
        $labSubCategories = SubCategoryLab::with('labSubCategory')->where([
            'lab_id'          => $request->lab,
            'lab_category_id' => $request->lab_category,
        ])->get();
        return view('providers_dashboards.doctor.reservations.reserve_lab', get_defined_vars());
    }

    public function sendPatientToLab(SendPatientToLabRequest $request, ReservationService $reservationService) {
        $doctorResrvation = Reservation::where(['doctor_id' => provider('doctor')->id, 'parent_id' => null])->findOrFail($request->reservation_id);
        $response = $reservationService->sendPatientToLab($request->validated(), $doctorResrvation);
        if (isset($response['key']) && $response['key'] == 'fail'){
            return  response()->json(['status' => 'fail' ,'msg' => $response['msg']]);
        }
        return response()->json(['status' => 'success']);
    }

    public function addPrescriptionForm(AddNewRageteRequest $request) {
        Ragite::create($request->validated());
        return response()->json([
            'status' => 'success',
            'msg'    => __('apis.addAdded'),
            'url'    => url()->previous(),
        ]);
    }

    public function writePrescription(WriteRegeteRequest $request) {

        if (count($request->medicines) !== count($request->hours) || count($request->medicines) !== count($request->times)) {
            return response()->json([
                'status' => 'fail',
                'msg'    => __('apis.error'),
            ]);
        }

        $reservation = provider('doctor')->reservations()->findOrFail($request->reservation_id);

        // if ($reservation->status == 'finished') {
        //     return response()->json([
        //         'status' => 'fail',
        //         'msg'    => __('apis.error'),
        //     ]);
        // }

        DB::beginTransaction();

        try {
            $medicalRecord = MedicalRecord::create($request->validated());
            for ($i = 0; $i < count($request->medicines); $i++) {
                $medicalRecord->medicalRecordMedicans()->create([
                    'medical_record_id' => $medicalRecord->id,
                    'doctor_medican_id' => $request->medicines[$i],
                    'hours'             => $request->hours[$i],
                    'times'             => $request->times[$i],
                    'reservation_id'    => $request->reservation_id,
                ]);
            }

            $reservation->update([
                'status' => 'finished',
            ]);

            Notification::send($reservation->user, new DoctorFinishReservationNotification($request->reservation_id));

            DB::commit();

            return response()->json([
                'status' => 'success',
                'msg'    => __('apis.success'),
                'html'   => view('providers_dashboards.doctor.reservations.details._print_prescription_model', compact('medicalRecord', 'reservation'))->render(),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            info('doctor -> reservationController -> writePrescription function error : ' . $e->getMessage());
            return response()->json([
                'status' => 'fail',
                'msg'    => __('apis.error'),
            ]);
        }

    }

}
