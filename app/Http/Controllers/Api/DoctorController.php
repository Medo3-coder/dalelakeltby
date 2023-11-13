<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddComplaintRequest;
use App\Http\Resources\Api\Doctor\DoctorCommentsResource;
use App\Http\Resources\Api\Doctor\DoctorDetailsResource;
use App\Http\Resources\Api\Doctor\DoctorResource;
use App\Models\Complaint;
use App\Models\Doctor;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DoctorController extends Controller {
    use ResponseTrait;

    public function doctorFilter(Request $request) {
        $doctors = Doctor::appFilter($request->all())->get();
        return $this->successData(DoctorResource::collection($doctors));
    }

    public function doctorDetails($id) {
        $doctor = Doctor::findOrFail($id);
        return $this->successData(new DoctorDetailsResource($doctor));
    }

    public function comments($id) {
        $doctor = Doctor::with('reservations', 'reservations.user')->findOrFail($id);
        return $this->successData(DoctorCommentsResource::collection($doctor->reservations));
    }

    public function addComplaint(AddComplaintRequest $request) {
        $additions = [];
        if(auth()->check()){
            $additions = ['user_id' => auth()->id()];
        }
        Complaint::create($request->validated() + ($additions));
        return $this->successMsg(__('apis.success'));
    }

}
