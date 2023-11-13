<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MedicalRecord\MedicalRecordsResource;
use App\Http\Resources\Api\MedicalRecord\MedicalRecordResource;
use App\Models\Reservation;
use App\Models\MedicalRecordMedican;
use App\Traits\ResponseTrait;
use App\Jobs\MedicineNextTimeNotificationJob;
use Carbon\Carbon;

class MedicalRecordController extends Controller {
    use ResponseTrait;

    public function personalRecord() {
        $reservations = Reservation::with('MedicalRecord', 'doctor' ,'doctor.category' ,'doctor.city')->where('type' ,'doctor')->whereHas('doctor')->where([
            'user_id'         => auth()->id(),
            'reservation_for' => 'same_person',
            'status'          => 'finished',
        ])->get();
        return $this->successData(MedicalRecordsResource::collection($reservations));
    }
    public function familyRecord() {
        $reservations = Reservation::with('MedicalRecord', 'doctor' ,'doctor.category' ,'doctor.city')->whereHas('doctor')->where([
            'user_id'         => auth()->id(),
            'reservation_for' => 'family',
            'status'          => 'finished',
        ])->get();
        return $this->successData(MedicalRecordsResource::collection($reservations));
    }

    public function medicalRecordDetails($reservation_id){
        $reservation  = Reservation::with('user' ,'doctor' ,'images' , 'MedicalRecord','MedicalRecord.medicalRecordMedicans' ,'MedicalRecord.medicalRecordMedicans.doctorMedicine')->where('type' ,'doctor')->find($reservation_id);
        return $this->successData(new MedicalRecordResource($reservation));
    }

    public function startUseReceipt($reservation_id){
        $reservation  = Reservation::with('user', 'MedicalRecord','MedicalRecord.medicalRecordMedicans' ,'MedicalRecord.medicalRecordMedicans.doctorMedicine')->findOrFail($reservation_id);
        
        if ($reservation->MedicalRecord->start_receipt){
            return $this->failMsg(__('apis.error'));
        }

        foreach ($reservation->MedicalRecord->medicalRecordMedicans as $recordMedicine){
            $time = Carbon::now()->addHours($recordMedicine->hours);
            MedicineNextTimeNotificationJob::dispatch($recordMedicine ,$reservation->user)->delay($time);
            $recordMedicine->update([
               'next_time' =>  $time
            ]);
        }
        $reservation->MedicalRecord->update(['start_receipt' => true]);
        return $this->successMsg(__('apis.start_use_receipt_successfuly'));
    }

    public function theMedicineHasBeenTaken($medicine_id){
        $medicalRecordMedican = MedicalRecordMedican::findOrFail($medicine_id);
        $time = Carbon::now()->addHours($medicalRecordMedican->hours);
        MedicineNextTimeNotificationJob::dispatch($medicalRecordMedican ,auth()->user())->delay($time);
        $medicalRecordMedican->update([
            'next_time' =>  $time
        ]);
        return $this->successData([
              'next_time' =>  $time->diffForHumans()
          ]);
    }
}
