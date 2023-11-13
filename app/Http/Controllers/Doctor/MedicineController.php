<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Medicine\Store;
use App\Http\Requests\Doctor\Medicine\Update;
use App\Models\DoctorMedicine;
use App\Traits\ResponseTrait;

class MedicineController extends Controller {
    use ResponseTrait;
    public function index() {
        $medicines = provider('doctor')->medicines; 
        return view('providers_dashboards.doctor.medicine.index' ,compact('medicines'));
    }

    public function create() {
        return view('providers_dashboards.doctor.medicine.create');
    }

    public function store(Store $request) {
        provider('doctor')->medicines()->create($request->validated());
        return response()->json([
            'msg'    => __('apis.success'),
            'status' => 'success',
            'url'    => route('doctor.medicine.index'),
        ]);
    }
    
    public function edit($medicine_id) {
        $medicine = DoctorMedicine::findOrFail($medicine_id);
        return view('providers_dashboards.doctor.medicine.edit' ,compact('medicine'));
    }

    public function update(Update $request ,$medicine_id) {
        $medicine = DoctorMedicine::findOrFail($medicine_id);
        $medicine->update($request->validated());
        return response()->json([
            'msg'    => __('apis.updated'),
            'status' => 'success',
            'url'    => route('doctor.medicine.index'),
        ]);
    }

    public function delete($medicine_id){
        DoctorMedicine::findOrFail($medicine_id)->delete();
        return $this->successMsg();
    }


}
