<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LabBranch\Store as LabBranchStore;
use App\Http\Requests\Admin\LabBranch\Update as LabBranchUpdate;
use App\Http\Requests\Admin\labs\Store;
use App\Http\Requests\Admin\labs\Update;
use App\Mail\AdminAcceptJoinRequestMail;
use App\Models\Country;
use App\Models\Lab;
use App\Models\LabBranch;
use App\Models\LabBranchDate;
use App\Models\LabBranchImage;
use App\Models\LabCategory;
use App\Models\TargetBodyArea;
use App\Traits\Report;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LabController extends Controller {
    use SmsTrait;
    public function index($id = null) {
        $labs = Lab::query();
        if (request()->ajax()) {
            if (request()->segment(3) == "pending" || request()->segment(3) == "accept") {
                $status = request()->segment(3) == "pending" ? "pending" : "accepted";
                $labs   = $labs->where('is_approved', $status)->search(request()->searchArray)->paginate(30);
            } else {
                $labs = Lab::search(request()->searchArray)->paginate(30);
            }
            $html = view('admin.labs.table', compact('labs'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.labs.index');
    }

    public function create() {
        $keys        = Country::get();
        $bodyAreas   = TargetBodyArea::get();
        $labCategory = LabCategory::get();
        return view('admin.labs.create', compact('keys', "bodyAreas", 'labCategory'));
    }

    public function store(Store $request) {
        dd($request->all());
        $lab          = Lab::create($request->validated());
        $lab_category = $lab->labCategories()->attach($request['category_ids']);

        // $food->allergies()->attach($allergy_ids, $severity_ids);

        if ($request->sonar_types) {
            $lab_sonar = $lab->labSonarTypes()->create([
                'sonar_type_id' => $request['sonar_types'],
                'price'         => $request['price'],
            ]);
        }

        if ($request['target_body_ids']) {
            foreach ($request->target_body_ids as $target_body) {
                // dd($target_body);
                $target_area = $lab->sonarTargetBody()->create([
                    'target_body_id' => $target_body,
                ]);
            }
        }

        // foreach($request->body_types as $key)
        // {
        //     dd($key);
        //     LabSonarTagetBody::create([
        //         'lab_id'         =>  $lab->id,
        //         'target_body_id'  => $key
        //        ]);
        // }

        Report::addToLog('  اضافه المختبر');
        return response()->json(['url' => route('admin.labs.index')]);
    }
    public function edit($id) {
        $lab  = Lab::findOrFail($id);
        $keys = Country::get();
        return view('admin.labs.edit', ['lab' => $lab, "keys" => $keys]);
    }

    public function update(Update $request, $id) {
        $lab = Lab::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل المختبر');
        return response()->json(['url' => route('admin.labs.index')]);
    }

    public function show($id) {
        $lab = Lab::findOrFail($id);
        return view('admin.labs.show', ['lab' => $lab]);
    }
    public function destroy($id) {
        $lab = Lab::findOrFail($id);
        $lab->branches->each(function ($branch) {
            $branch->images->each->delete();
            $branch->delete();
        });
        $lab->delete();
        Report::addToLog('  حذف المختبر');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if ($labs = Lab::with('branches', 'branches.images')->WhereIn('id', $ids)->get()) {
            foreach ($labs as $lab) {
                $lab->branches->each(function ($branch) {
                    $branch->images->each->delete();
                    $branch->delete();
                });
                $lab->delete();
            }
            Report::addToLog('  حذف العديد من المختبرات');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }

    public function acceptOrRefuse(Request $request, $id) {
        $doctor = Lab::findOrFail($id);
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

    public function labBranchs($id = null) {

        if (request()->ajax()) {

            $lab_branches = LabBranch::where('lab_id', $id)->search(request()->searchArray)->paginate(30);

            $html = view('admin.labs.branches.table', compact('lab_branches'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.labs.branches.index', compact("id"));
    }

    public function createBranch($id = null) {

        return view('admin.labs.branches.create', compact("id"));
    }

    public function storeBranch(LabBranchStore $request) {

        // dd(request()->all());
        $branch = LabBranch::create($request->validated());
        $dates  = [];

        foreach ($request['days'] as $key => $ex) {
            $dates[$key]['day']    = $ex;
            $dates[$key]['from']   = $request->from[$key];
            $dates[$key]['to']     = $request->to[$key];
            $dates[$key]['lab_id'] = $request->lab_id;
        }
        $branch->dates()->createMany($dates);
        foreach ($request->images as $img) {
            $branch->images()->create([
                'lab_branch_id' => $branch->id,
                'lab_id'        => $request->lab_id,
                'image'         => $img,
            ]);
        }

        Report::addToLog('  اضافه فرع عيادة');
        return response()->json(['url' => route('admin.lab.branchs.all', ['id' => $request->lab_id])]);
    }

    public function showBranch($id) {
        $row     = LabBranch::findOrFail($id);
        $timings = LabBranchDate::where('lab_id', $row->id)->get();
        $images  = LabBranchImage::where('lab_branch_id', $row->id)->get();

        return view('admin.labs.branches.show', ['row' => $row, 'timings' => $timings ,'images'=> $images]);
    }

    public function editBranch($id) {
        $row     = LabBranch::findOrFail($id);
        $timings = LabBranchDate::where('lab_branch_id', $row->id)->get();
        $images  = LabBranchImage::where('lab_branch_id', $row->id)->get();

        return view('admin.labs.branches.edit', ['row' => $row, "id" => $id, "timings" => $timings, "images" => $images]);
    }

    public function updateBranch(LabBranchUpdate $request, $id) {
        $branch = LabBranch::findOrFail($id);
        $branch->update($request->validated());
        $branch->dates->each->delete();
        $dates = [];
        foreach ($request['days'] as $key => $ex) {
            $dates[$key]['day']    = $ex;
            $dates[$key]['from']   = $request->from[$key];
            $dates[$key]['to']     = $request->to[$key];
            $dates[$key]['lab_id'] = $request->lab_id;
        }
        $branch->dates()->createMany($dates);

        if ($request->images) {
            foreach ($request->images as $img) {
                $branch->images()->create([
                    'pharmacist_id'      => $request->pharmacist_id,
                    'pharmacy_branch_id' => $branch->id,
                    'image'              => $img,
                ]);
            }
        }

        Report::addToLog('  تعديل فرع عيادة');
        return response()->json(['url' => route('admin.lab.branchs.all', ['id' => $request->lab_id])]);
    }

    public function destroyBranch($id) {
        $row = LabBranch::findOrFail($id)->delete();
        Report::addToLog('  حذف فرع مختبر');
        return response()->json(['id' => $id]);
    }

    public function deleteImage($id) {
        $row = LabBranchImage::findOrFail($id)->delete();
        Report::addToLog('حذف صورة مختبر');
        return response()->json(['id' => $id]);
    }
}
