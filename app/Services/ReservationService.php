<?php
namespace App\Services;

use App\Models\Clinics;
use App\Models\Doctor;
use App\Models\Lab;
use App\Models\LabBranch;
use App\Models\Reservation;
use App\Models\SiteSetting;
use App\Models\SubCategoryLab;
use App\Models\User;
use App\Notifications\DoctorReserveLabForPatient;
use App\Notifications\LabDoctorMakeReservation;
use App\Notifications\NewDoctorReservationNotification;
use App\Notifications\NewLabReservationNotification;
use App\Services\SettingService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ReservationService {

    public function store($request) {
        DB::beginTransaction();
        try {
            $availableReservationsNumberPerDay = null;
            $currentDayReservations            = null;
            $availableReservationThisDay       = null;

            if ($request['type'] == 'doctor') {
                $availableReservationsNumberPerDay = (int) SiteSetting::where('key', 'reservations_number_per_day')->first()->value;
                $currentDayReservations            = Reservation::where(['type' => 'doctor'])->where(['user_id' => auth()->id()])->whereDate('created_at', now())->count();
                $availableReservationThisDay       = $availableReservationsNumberPerDay - ($currentDayReservations + 1);
                if ($availableReservationsNumberPerDay == $currentDayReservations) {
                    return ['key' => 'fail', 'msg' => __('apis.you_have_reach_available_reservations_number_per_day')];
                }

                $dates = Clinics::with('dates')->findOrFail($request['clinic_id'])->dates;
            } else {
                $dates = LabBranch::with('dates')->findOrFail($request['lab_branch_id'])->dates;
            }

            if (!isset($request['from_lab']) || !$request['from_lab']) {
                $request['user_id'] = auth()->id();
            }
            $request = $request + $this->calculatPrice($request);

            $this->validateDates($request, $dates);

            if ($request['payment_method'] == 'wallet' && auth()->user()->wallet_balance < $request['final_total']) {
                return ['key' => 'fail', 'msg' => __('apis.no_enough_balance_in_wallet')];
            }

            $reservation = Reservation::create($request);

            $payment = new PaymentService($reservation, $request);

            $payment->reservationPayment();

            if (isset($request['images'])) {
                foreach ($request['images'] as $image) {
                    $fileMimeType = $image->getClientmimeType();
                    $imageCheck   = explode('/', $fileMimeType);
                    $reservation->images()->create(['image' => $image, 'type' => $imageCheck[0] == 'image' ? 'image' : 'file']);
                }
            }

            if (isset($request['sub_category_lab_id'])) {
                $reservation->labSubCategories()->attach($request['sub_category_lab_id']);
            }

            if ($request['type'] == 'doctor') {
                Notification::send(Doctor::find($request['doctor_id']), new NewDoctorReservationNotification($reservation->id, route('doctor.reservations.new')));
            } else {
                Notification::send(Lab::find($request['lab_id']), new NewLabReservationNotification($reservation->id, route('lab.newReservations')));
            }

            DB::commit();

            return ['key' => 'success', 'reservations' => $reservation->refresh(), 'available_reservations_count' => $availableReservationThisDay];
        } catch (Exception $e) {
            DB::rollBack();
            info('reservation service make reservation in store function error : ' . $e->getMessage(), ['exception' => $e]);
            return ['key' => 'fail', 'msg' => $e->getMessage()];
        }
    }

    public function calculatPrice($request) {
        $settings = SettingService::appInformations(SiteSetting::pluck('value', 'key'));
        $array    = [];
        if ($request['type'] == 'doctor') {
            $clinic                     = Clinics::findorFail($request['clinic_id']);
            $array['detection_price']   = $clinic->detection_price;
            $array['reservation_price'] = $settings['reservation_price'];
            $totalPrice                 = $settings['reservation_price'] + $clinic->detection_price;
        } else {
            $subCategories           = SubCategoryLab::whereIn('id', $request['sub_category_lab_id'])->get();
            $totalPrice              = $subCategories->sum('price');
            $array['analysis_price'] = $totalPrice;
        }

        $vatAmount  = $totalPrice * $settings['vat_rate_ratio'] / 100;
        $finalPrice = $totalPrice + $vatAmount;

        $array = array_merge($array, [
            'admin_commission_ratio'  => $settings['admin_commission_ratio'],
            'admin_commission_amount' => $finalPrice * $settings['admin_commission_ratio'] / 100,
            'vat_rate_ratio'          => $settings['vat_rate_ratio'],
            'vat_rate_amount'         => $vatAmount,
            'total_price'             => $totalPrice,
            'final_total'             => $finalPrice,
        ]);
        return $array;
    }

    public function sendPatientToLab($data, $doctorReservation) {
        $labBranch       = Lab::findOrFail($data['lab_id'])->branches()->select(DB::raw("id, ( 3959 * acos( cos( radians('$doctorReservation->lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$doctorReservation->lng') ) + sin( radians('$doctorReservation->lat') ) * sin( radians( lat ) ) ) ) AS distance"))->orderBy('distance')->first();
        $reservationData = array_merge($data, [
            'from_lab'             => true,
            'parent_id'            => $doctorReservation->id,
            'lab_branch_id'        => $labBranch->id,
            'type'                 => 'lab',
            'lng'                  => $doctorReservation->lng,
            'lat'                  => $doctorReservation->lat,
            'reservation_for'      => $doctorReservation->reservation_for,
            'user_id'              => $doctorReservation->user_id,
            'doctor_id'            => $doctorReservation->doctor_id,
            'paient_name'          => $doctorReservation->paient_name,
            'paient_blood_type_id' => $doctorReservation->paient_blood_type_id,
            'paient_age'           => $doctorReservation->paient_age,
            'paient_weight'        => $doctorReservation->paient_weight,
            'paient_height'        => $doctorReservation->paient_height,
            'payment_method'       => 'sms', /// not in the design
        ]);
        $reservation = $this->store($reservationData);

        $doctorReservation->update([
            'status' => 'transfer_to_lab',
            // 'lab_branch_id' => $labBranch->id,
            // 'lab_id'        => $data['lab_id'],
        ]);

        if (isset($reservation['reservations'])){
            // notify user new reservation to lab
            Notification::send($doctorReservation->user, new DoctorReserveLabForPatient($reservation['reservations']->id));
            // notify lab that doctor make reservation
            Notification::send(Lab::find($data['lab_id']), new LabDoctorMakeReservation($reservation['reservations']->id));
        }

        return $reservation;
    }

    protected function validateDates($data, $dates) {

        $reservationDay = Carbon::parse($data['date'])->dayOfWeek;

//        info('sdfsdfsdfsdsd' ,['data' => $data]);

        $day = null;
        foreach ($dates as $key => $date) {
            if ($this->getWeekDayValue($date->day) == $reservationDay) {
                $day = $date;
            }
        }
        if (!($day && Carbon::parse($data['time'])->between($date->from, $date->to))) {
            throw new Exception(__('apis.this_time_not_in_the_workin_times'));
        }

    }

    protected function getWeekDayValue($day) {
        switch (strtolower($day)) {
        case 'saturday':
            return Carbon::SATURDAY;
            break;
        case 'sunday':
            return Carbon::SUNDAY;
            break;
        case 'monday':
            return Carbon::MONDAY;
            break;
        case 'tuesday':
            return Carbon::TUESDAY;
            break;
        case 'wednesday':
            return Carbon::WEDNESDAY;
            break;
        case 'thursday':
            return Carbon::THURSDAY;
            break;
        case 'friday':
            return Carbon::FRIDAY;
            break;

        default:
            throw new Exception(__('apis.this_time_not_in_the_workin_times'));
            break;
        }
    }
}
