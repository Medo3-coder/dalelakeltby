<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\storesbranches\Store as StoresbranchesStore;
use App\Http\Requests\Admin\storesbranches\Update as StoresbranchesUpdate;
use App\Http\Requests\Admin\stores\Store as StoresStore;
use App\Http\Requests\Admin\stores\Update;
use App\Mail\AdminAcceptJoinRequestMail;
use App\Models\Country;
use App\Models\Store;
use App\Models\StoreBranch;
use App\Models\StoreBranchImage;
use App\Models\StoreDate;
use App\Traits\Report;
use App\Traits\SmsTrait;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StoreController extends Controller {

    use SmsTrait;

    public function index($id = null) {
        $stores = Store::query();
        if (request()->ajax()) {
            if (request()->segment(3) == "pending" || request()->segment(3) == "accepted") {
                $status = request()->segment(3) == "pending" ? "pending" : "accepted";
//                dd($stores->where('is_approved', $status)->paginate(30));
                $stores = $stores->where('is_approved', $status)->search(request()->searchArray)->paginate(30);
            } else {
                $stores = $stores->search(request()->searchArray)->paginate(30);
            }

            $html = view('admin.stores.table', compact('stores'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.stores.index');
    }

    public function create() {
        $keys = Country::get();
        return view('admin.stores.create', compact("keys"));
    }

    public function store(StoresStore $request) {
        Store::create($request->validated());
        Report::addToLog('  اضافه المتجر');
        return response()->json(['url' => route('admin.stores.index')]);
    }
    public function edit($id) {
        $stores = Store::findOrFail($id);
        $keys   = Country::get();
        return view('admin.stores.edit', ['stores' => $stores, "keys" => $keys]);
    }

    public function update(Update $request, $id) {
        $stores = Store::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل المتجر');
        return response()->json(['url' => route('admin.stores.index')]);
    }

    public function show($id) {
        $row = Store::findOrFail($id);
        return view('admin.stores.show', ['row' => $row]);
    }
    public function destroy($id) {
        $store = Store::with('branches', 'branches.images')->findOrFail($id);
        $store->branches->each(function ($branch) {
            $branch->images->each->delete();
            $branch->delete();
        });
        $store->delete();
        Report::addToLog('  حذف المتجر');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if ($stores = Store::with('branches', 'branches.images')->WhereIn('id', $ids)->get()) {
            foreach ($stores as $store) {
                $store->branches->each(function ($branch) {
                    $branch->images->each->delete();
                    $branch->delete();
                });
                $store->delete();
            }
        } else {
            return response()->json('failed');
        }
    }

    public function acceptOrRefuse(Request $request, $id) {
        $doctor = Store::findOrFail($id);
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

    public function storesBranchs($id = null) {
        if (request()->ajax()) {
            $stores_branches = StoreBranch::where('store_id', $id)->search(request()->searchArray)->paginate(30);
            $html            = view('admin.stores.branches.table', compact('stores_branches'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.stores.branches.index', compact("id"));
    }

    public function createBranch($id = null) {
        return view('admin.stores.branches.create', compact("id"));
    }

    public function storeBranch(StoresbranchesStore $request) {
        $Store = StoreBranch::create($request->validated());
        // $options = $request->only('store_id');
        $dates = [];
        foreach ($request['days'] as $key => $ex) {
            $dates[$key]['day']      = $ex;
            $dates[$key]['from']     = $request->from[$key];
            $dates[$key]['to']       = $request->to[$key];
            $dates[$key]['store_id'] = $request->store_id;
        }

        $Store->dates()->createMany($dates);
        foreach ($request->images as $img) {
            $Store->images()->create([
                'store_id'        => $request->store_id,
                'store_branch_id' => $Store->id,
                'image'           => $img,
            ]);
        }

        Report::addToLog('  اضافه فرع مبخر');
        return response()->json(['url' => route('admin.stores.branchs.all', ['id' => $request->store_id])]);
    }

    public function showBranch($id) {
        $row     = StoreBranch::findOrFail($id);
        $timings = StoreDate::where('store_branch_id', $row->id)->get();
        $images  = StoreBranchImage::where('store_branch_id', $row->id)->get();
        return view('admin.stores.branches.show', ['row' => $row, 'timings' => $timings, "images" => $images]);
    }

    public function editBranch($id) {
        $row     = StoreBranch::findOrFail($id);
        $timings = StoreDate::where('store_branch_id', $row->id)->get();
        $images  = StoreBranchImage::where('store_branch_id', $row->id)->get();
        return view('admin.stores.branches.edit', ['row' => $row, "id" => $id, "timings" => $timings, "images" => $images]);
    }

    public function updateBranch(StoresbranchesUpdate $request, $id) {
        $storebranch = StoreBranch::findOrFail($id);
        $storebranch->update($request->except('store_id'));
        $storebranch->dates->each->delete();
        $dates = [];
        foreach ($request['days'] as $key => $ex) {
            $dates[$key]['day']      = $ex;
            $dates[$key]['from']     = $request->from[$key];
            $dates[$key]['to']       = $request->to[$key];
            $dates[$key]['store_id'] = $request->store_id;
        }
        $storebranch->dates()->createMany($dates);
        if ($request->images) {
            foreach ($request->images as $img) {
                $storebranch->images()->create([
                    'store_id'        => $request->store_id,
                    'store_branch_id' => $storebranch->id,
                    'image'           => $img,
                ]);
            }
        }

        Report::addToLog('  تعديل فرع مبخر');
        return response()->json(['url' => route('admin.stores.branchs.all', ['id' => $request->store_id])]);
    }

    public function destroyClinicBranch($id) {
        $row = StoreBranch::findOrFail($id)->delete();
        Report::addToLog('  حذف فرع مبخر');
        return response()->json(['id' => $id]);
    }

    public function deleteImage($id) {
        $row = StoreBranchImage::findOrFail($id)->delete();
        Report::addToLog('حذف صورة مبخر');
        return response()->json(['id' => $id]);
    }
}
