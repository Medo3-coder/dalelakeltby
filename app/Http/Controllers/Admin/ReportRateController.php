<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportRate;
use App\Traits\Report;
use Illuminate\Http\Request;

class ReportRateController extends Controller {
    public function index($id = null) {
        if (request()->ajax()) {
            $reportrates = ReportRate::with('reportable')->search(request()->searchArray)->paginate(30);
            $html        = view('admin.reportrates.table', compact('reportrates'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.reportrates.index');
    }

    public function create() {
        return view('admin.reportrates.create');
    }

    public function show($id) {
        $reportrate = ReportRate::findOrFail($id);
        return view('admin.reportrates.show', ['reportrate' => $reportrate]);
    }
    public function destroy($id) {
        $reportrate = ReportRate::findOrFail($id)->delete();
        Report::addToLog('  حذف بلاغ');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (ReportRate::WhereIn('id', $ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من بلاغات');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
