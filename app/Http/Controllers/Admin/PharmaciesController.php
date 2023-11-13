<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PharmaciesBranch\Store as PharmaciesBranchStore;
use App\Http\Requests\Admin\PharmaciesBranch\Update as PharmaciesBranchUpdate;
use App\Http\Requests\Admin\Pharmacies\Store;
use App\Http\Requests\Admin\Pharmacies\Update;
use App\Mail\AdminAcceptJoinRequestMail;
use App\Mail\SendMail;
use App\Models\Country;
use App\Models\Pharmacist;
use App\Models\PharmacyBranch;
use App\Models\PharmacyBranchImage;
use App\Models\PharmacyDate;
use App\Notifications\BlockUser;
use App\Notifications\NotifyUser;
use App\Traits\Report;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Mail;

class PharmaciesController extends Controller {
    use SmsTrait;

    public function index($id = null) {
        $pharmacies = Pharmacist::query();
        if (request()->ajax()) {
            if (request()->segment(3) == "pending" || request()->segment(3) == "accept") {
                $status     = request()->segment(3) == "pending" ? "pending" : "accepted";
                $pharmacies = $pharmacies->where('is_approved', $status)->search(request()->searchArray)->paginate(30);
            } else {
                $pharmacies = $pharmacies->search(request()->searchArray)->paginate(30);
            }
            $html = view('admin.pharmacies.table', compact('pharmacies'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.pharmacies.index');
    }

    public function create() {
        $keys = Country::get();
        return view('admin.pharmacies.create', compact("keys"));
    }

    public function store(Store $request) {
        Pharmacist::create($request->validated());
        Report::addToLog('  اضافه صيدلية');
        return response()->json(['url' => route('admin.pharmacies.index')]);
    }

    public function edit($id) {
        $pharmacies = Pharmacist::findOrFail($id);
        $keys       = Country::get();

        return view('admin.pharmacies.edit', ['pharmacies' => $pharmacies, 'keys' => $keys]);
    }

    public function update(Update $request, $id) {
        $pharmacies = Pharmacist::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل صيدلية');
        return response()->json(['url' => route('admin.pharmacies.index')]);
    }

    public function show($id) {
        $row = Pharmacist::findOrFail($id);
        return view('admin.pharmacies.show', ['row' => $row]);
    }
    public function showfinancial($id) {
        $complaints = Pharmacist::where('user_id', $id)->paginate(10);
        return view('admin.complaints.user_complaints', ['complaints' => $complaints]);
    }

    public function destroy($id) {
        $pharmacy = Pharmacist::with('pharmacyBranch', 'pharmacyBranch.images')->findOrFail($id);
        $pharmacy->pharmacyBranch->each(function ($branch) {
            $branch->images->each->delete();
            $branch->delete();
        });
        $pharmacy->delete();
        Report::addToLog('  حذف صيدلية');
        return response()->json(['id' => $id]);
    }

    public function block(Request $request) {
        $pharmacies = Pharmacist::findOrFail($request->id);
        $pharmacies->update(['is_blocked' => !$pharmacies->is_blocked]);
        Notification::send($pharmacies, new BlockUser($request->all()));
        return response()->json(['message' => $pharmacies->refresh()->is_blocked == 1 ? __('admin.client_blocked') : __('admin.client_unblocked')]);
    }

    public function notify(Request $request) {
        if ($request->notify == 'notify') {
            if ('all' == $request->id) {
                $clients = Pharmacist::latest()->get();
            } else {
                $clients = Pharmacist::findOrFail($request->id);
            }
            Notification::send($clients, new NotifyUser($request->all()));
        } else {
            if ('all' == $request->id) {
                $mails = Pharmacist::where('email', '!=', null)->get()->pluck('email')->toArray();
            } else {
                $mails = Pharmacist::findOrFail($request->id)->email;
            }
            Mail::to($mails)->send(new SendMail(['title' => 'اشعار اداري', 'message' => $request->message]));
        }
        return response()->json();
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if ($pharmasists = Pharmacist::with('pharmacyBranch', 'pharmacyBranch.images')->WhereIn('id', $ids)->get()) {
            foreach ($pharmasists as $pharmacy) {
                $pharmacy->pharmacyBranch->each(function ($branch) {
                    $branch->images->each->delete();
                    $branch->delete();
                });
                $pharmacy->delete();
            }
        } else {
            return response()->json('failed');
        }
    }

    public function acceptOrRefuse(Request $request, $id) {
        $doctor = Pharmacist::findOrFail($id);
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

    public function PharamcyBranchs($id = null) {
        if (request()->ajax()) {

            $pharmacies_branches = PharmacyBranch::where('pharmacist_id', $id)->search(request()->searchArray)->paginate(30);

            $html = view('admin.pharmacies.branches.branches_table', compact('pharmacies_branches'))->render();
            return response()->json(['html' => $html]);
        }
        $pharmacies = Pharmacist::latest()->get();
        return view('admin.pharmacies.branches.branch_index', compact("id"));
    }

    public function createBranch($id = null) {
        return view('admin.pharmacies.branches.create', compact("id"));
    }

    public function storeBranch(PharmaciesBranchStore $request) {
        $pharmacy = PharmacyBranch::create($request->validated());
        $dates    = [];
        foreach ($request['days'] as $key => $ex) {
            $dates[$key]['day']           = $ex;
            $dates[$key]['from']          = $request->from[$key];
            $dates[$key]['to']            = $request->to[$key];
            $dates[$key]['pharmacist_id'] = $request->pharmacist_id;

        }
        $pharmacy->dates()->createMany($dates);

        // dd($request->pharmacist_id);
        foreach ($request->images as $img) {
            $pharmacy->images()->create([
                'pharmacy_branch_id' => $pharmacy->id,
                'pharmacist_id'      => $request->pharmacist_id,
                'image'              => $img,
            ]);
        }
        Report::addToLog('  اضافه فرع صيدليه');
        return response()->json(['url' => route('admin.pharmacies.branchs.all', ['id' => $request->pharmacist_id])]);
    }

    public function showBranch($id) {
        $row     = PharmacyBranch::findOrFail($id);
        $timings = PharmacyDate::where('pharmacy_branch_id', $row->id)->get();
        $images  = PharmacyBranchImage::where('pharmacy_branch_id', $row->id)->get();
        return view('admin.pharmacies.branches.show', ['row' => $row, "timings" => $timings, "images" => $images]);
    }

    public function editBranch($id) {
        $row     = PharmacyBranch::findOrFail($id);
        $timings = PharmacyDate::where('pharmacy_branch_id', $row->id)->get();
        $images  = PharmacyBranchImage::where('pharmacy_branch_id', $row->id)->get();

        return view('admin.pharmacies.branches.edit', ['row' => $row, "images" => $images, "timings" => $timings]);
    }

    public function updateBranch(PharmaciesBranchUpdate $request, $id) {
        $pharmacies = PharmacyBranch::findOrFail($id);
        $pharmacies->update($request->validated());
        $pharmacies->dates->each->delete();
        $dates = [];
        foreach ($request['days'] as $key => $ex) {
            $dates[$key]['day']           = $ex;
            $dates[$key]['from']          = $request->from[$key];
            $dates[$key]['to']            = $request->to[$key];
            $dates[$key]['pharmacist_id'] = $request->pharmacist_id;
        }
        $pharmacies->dates()->createMany($dates);

        if ($request->images) {
            foreach ($request->images as $img) {
                $pharmacies->images()->create([
                    'pharmacist_id'      => $request->pharmacist_id,
                    'pharmacy_branch_id' => $pharmacies->id,
                    'image'              => $img,
                ]);
            }
        }

        Report::addToLog('  تعديل صيدلية');
        return response()->json(['url' => route('admin.pharmacies.branchs.all', ['id' => $request->pharmacist_id])]);
    }

    public function destroyBranch($id) {
        $row = PharmacyBranch::findOrFail($id)->delete();
        Report::addToLog('  حذف فرع صيدلية');
        return response()->json(['id' => $id]);
    }

    public function deleteImage($id) {
        $row = PharmacyBranchImage::findOrFail($id)->delete();
        Report::addToLog('حذف صورة صيدلية');
        return response()->json(['id' => $id]);
    }
}
