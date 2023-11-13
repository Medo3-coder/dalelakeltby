<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\clinicsbranch\Store as ClinicsbranchStore;
use App\Http\Requests\Admin\clinicsbranch\Update as ClinicsbranchUpdate;
use App\Http\Requests\Admin\doctors\Store;
use App\Http\Requests\Admin\doctors\Update;
use App\Mail\AdminAcceptJoinRequestMail;
use App\Models\Category;
use App\Models\ClinicDate;
use App\Models\ClinicImages;
use App\Models\Clinics;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Traits\Report;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DoctorController extends Controller {

    use SmsTrait;

    public function index($id = null) {
        $doctors = Doctor::query();

        if (request()->ajax()) {
            if (request()->segment(3) == "pending" || request()->segment(3) == "accept") {
                $doctors = $doctors->where('is_approved', request()->segment(3) == "pending" ? "pending" : "accepted")
                    ->search(request()->searchArray)->paginate(30);
            } else {
                $doctors = $doctors->search(request()->searchArray)->paginate(30);
            }
            $html = view('admin.doctors.table', compact('doctors'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.doctors.index');
    }

    public function create() {
        $specilaties    = Specialty::get();
        $subSpecilaties = Specialty::where('parent_id', "!=", "NULL")->get();
        $keys           = Country::get();
        $categories     = Category::get();
        return view('admin.doctors.create', compact('specilaties', 'keys', 'subSpecilaties', 'categories'));
    }

    public function store(Store $request) {
        Doctor::create($request->validated());
        Report::addToLog('اضافه الاطباء');
        return response()->json(['url' => route('admin.doctors.index')]);
    }
    public function edit($id) {

        $doctor         = Doctor::findOrFail($id);
        $specilaties    = Specialty::all();
        $subSpecilaties = Specialty::where('parent_id', "!=", "NULL")->get();
        $keys           = Country::get();
        return view('admin.doctors.edit', ['doctor' => $doctor, 'specilaties' => $specilaties, "subSpecilaties" => $subSpecilaties, "keys" => $keys]);
    }

    public function update(Update $request, $id) {
        $doctor = Doctor::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل الاطباء');
        return response()->json(['url' => route('admin.doctors.index')]);
    }

    public function show($id) {
        $doctor = Doctor::findOrFail($id);

        $specilaties    = Specialty::all();
        $subSpecilaties = Specialty::where('parent_id', "!=", "NULL")->get();
        // dd( $subSpecilaties);
        $categories = Category::get();
        $keys       = Country::get();

        return view('admin.doctors.show', ['doctor' => $doctor, 'specilaties' => $specilaties, "subSpecilaties" => $subSpecilaties, "categories" => $categories, "keys" => $keys]);
    }
    public function destroy($id) {
        $doctor = Doctor::with('clinics', 'clinics.images')->findOrFail($id);
        $doctor->clinics->each(function ($clinic) {
            $clinic->images->each->delete();
            $clinic->delete();
        });
        $doctor->delete();
        Report::addToLog('  حذف الاطباء');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if ($doctors = Doctor::with('clinics', 'clinics.images')->WhereIn('id', $ids)->get()) {
            foreach ($doctors as $doctor) {
                $doctor->clinics->each(function ($clinic) {
                    $clinic->images->each->delete();
                    $clinic->delete();
                });
                $doctor->delete();
            }
            Report::addToLog('  حذف العديد من الاطباء');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }

    public function acceptOrRefuse(Request $request, $id) {
        $doctor = Doctor::findOrFail($id);
        if ($request->is_approved == "accepted") {
            $doctor->update(['is_approved' => $request->is_approved]);

            $this->sendSms($doctor->full_phone, __('admin.admin_accept_your_request'));
            // Mail::to($doctor, new AdminAcceptJoinRequestMail());

            return back()->with('success', 'تم الارسال');
        } elseif ($request->is_approved == 'rejected') {
            $doctor->update(['is_approved' => $request->is_approved]);
            return back()->with('success', 'تم الارسال');
        } else {
            return response()->json('failed');
        }
    }

    public function clinicbranch($id = null) {
        if (request()->ajax()) {

            $clinics_branches = Clinics::where('doctor_id', $id)->search(request()->searchArray)->paginate(30);

            $html = view('admin.doctors.clinics.table', compact('clinics_branches'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.doctors.clinics.index', compact("id"));
    }

    public function createClinicBranch($id = null) {
        return view('admin.doctors.clinics.create', compact("id"));
    }

    public function storeClinicBranch(ClinicsbranchStore $request) {

        $clinic = Clinics::create($request->except(['days', 'from', 'to', 'clinic_id']));
        $dates  = [];
        foreach ($request['days'] as $key => $ex) {
            $dates[$key]['day']       = $ex;
            $dates[$key]['from']      = $request->from[$key];
            $dates[$key]['to']        = $request->to[$key];
            $dates[$key]['clinic_id'] = $request->clinic_id;
        }
        $clinic->dates()->createMany($dates);
        foreach ($request['images'] as $img) {
            $clinic->images()->create([
                'clinic_id' => $clinic->id,
                'doctor_id' => $request->doctor_id,
                'image'     => $img,
            ]);
        }

        Report::addToLog('  اضافه فرع عيادة');
        return response()->json(['url' => route('admin.doctors.branchs.all', ['id' => $request->doctor_id])]);
    }

    public function showClinicBranch($id) {
        $row     = Clinics::findOrFail($id);
        $timings = ClinicDate::where('clinic_id', $row->id)->get();
        $images  = ClinicImages::where('clinic_id', $row->id)->get();
        return view('admin.doctors.clinics.show', ['row' => $row, 'timings' => $timings, "images" => $images]);
    }

    public function editClinicBranch($id) {
        $row     = Clinics::findOrFail($id);
        $timings = ClinicDate::where('clinic_id', $row->id)->get();
        $images  = ClinicImages::where('clinic_id', $row->id)->get();
        return view('admin.doctors.clinics.edit', ['row' => $row, "id" => $id, "timings" => $timings, "images" => $images]);
    }

    public function updateClinicBranch(ClinicsbranchUpdate $request, $id) {
        // dd($request->all());
        $clinic = Clinics::findOrFail($id);
        $clinic->update($request->validated());
        $clinic->dates->each->delete();
        $dates = [];
        foreach ($request['days'] as $key => $ex) {
            $dates[$key]['day']  = $ex;
            $dates[$key]['from'] = $request->from[$key];
            $dates[$key]['to']   = $request->to[$key];
        }
        $clinic->dates()->createMany($dates);
        if ($request->images) {
            foreach ($request['images'] as $img) {
                $clinic->images()->create([
                    'clinic_id' => $clinic->id,
                    'doctor_id' => $request->doctor_id,
                    'image'     => $img,
                ]);
            }
        }
        Report::addToLog('  تعديل فرع عيادة');
        return response()->json(['url' => route('admin.doctors.branchs.all', ['id' => $request->doctor_id])]);
    }

    public function destroyClinicBranch($id) {
        $row = Clinics::findOrFail($id)->delete();
        Report::addToLog('  حذف فرع عيادة');
        return response()->json(['id' => $id]);
    }

    public function deleteImage($id) {
        // dd($id);
        $row = ClinicImages::findOrFail($id)->delete();
        Report::addToLog('حذف صورة عيادة');
        return response()->json(['id' => $id]);
    }
}
