<?php

namespace App\Http\Controllers\Admin;

use App\Builders\Input;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\cancelreasons\Store;
use App\Http\Requests\Admin\cancelreasons\Update;
use App\Models\CancelReason;
use App\Traits\Report;
use Illuminate\Http\Request;

class CancelReasonController extends Controller {
    private function inputs($options = null) {
        return [
            'reason' => Input::createArEnInput(__('admin.reason_ar'), __('admin.reason_en'), __('admin.reason_kur'))->build(),
        ];
    }

    public function index($id = null) {
        if (request()->ajax()) {
            $cancelreasons = CancelReason::search(request()->searchArray)->paginate(30);
            $html          = view('admin.cancelreasons.table', compact('cancelreasons'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.cancelreasons.index');
    }

    public function create() {
        // $users = User::get();
        return view('admin.cancelreasons.create', ['inputs' => $this->inputs([
            // 'users' => $users
        ])]);
    }

    public function store(Store $request) {
        CancelReason::create($request->validated());
        Report::addToLog('  اضافه سبب الالغاء');
        return response()->json(['url' => route('admin.cancelreasons.index')]);
    }
    public function edit($id) {
        $cancelreason = CancelReason::findOrFail($id);
        // $files = $cancelreason->files;
        // $users = User::get();
        return view('admin.cancelreasons.edit', ['item' => $cancelreason, 'inputs' => $this->inputs([
            // 'users' => $users,
            // 'files' => $files
        ])]);
    }

    public function update(Update $request, $id) {
        $cancelreason = CancelReason::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل سبب الالغاء');
        return response()->json(['url' => route('admin.cancelreasons.index')]);
    }

    public function show($id) {
        $cancelreason = CancelReason::findOrFail($id);
        // $files = $cancelreason->files;
        // $users = User::get();
        return view('admin.cancelreasons.show', ['item' => $cancelreason, 'inputs' => $this->inputs([
            // 'users' => $users,
            // 'files' => $files
        ])]);
    }
    public function destroy($id) {
        $cancelreason = CancelReason::findOrFail($id)->delete();
        Report::addToLog('  حذف سبب الالغاء');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (CancelReason::WhereIn('id', $ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من اسباب الالغاء');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
