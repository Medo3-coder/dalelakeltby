<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\labcategories\Store;
use App\Http\Requests\Admin\labcategories\Update;
use App\Models\LabCategory;
use App\Traits\Report;
use Illuminate\Http\Request;

class LabCategoryController extends Controller {
    public function index($id = null) {
        if (request()->ajax()) {
            $labcategories = LabCategory::where('parent_id', $id)->search(request()->searchArray)->paginate(30);
            $html          = view('admin.labcategories.table', compact('labcategories'))->render();
            return response()->json(['html' => $html]);
        }
        $parent = $id !== null ? LabCategory::findOrFail($id) : null;
        return view('admin.labcategories.index' ,compact('parent'));
    }

    public function create($parent_id) {
        $parent = LabCategory::find($parent_id);
        return view('admin.labcategories.create' ,compact('parent'));
    }

    public function store(Store $request ,$parent_id = null) {
        LabCategory::create($request->validated());
        Report::addToLog('  اضافه قسم المختبر');
        return response()->json(['url' => route('admin.labcategories.index' ,$parent_id)]);
    }
    public function edit($id) {
        $labcategory = LabCategory::findOrFail($id);
        return view('admin.labcategories.edit', ['labcategory' => $labcategory]);
    }

    public function update(Update $request, $id) {
        $labcategory = LabCategory::findOrFail($id);
        $labcategory->update($request->validated());
        Report::addToLog('  تعديل قسم المختبر');
        return response()->json(['url' => route('admin.labcategories.index' ,$labcategory->parent_id)]);
    }

    public function show($id) {
        $labcategory = LabCategory::findOrFail($id);
        return view('admin.labcategories.show', ['labcategory' => $labcategory]);
    }
    public function destroy($id) {
        $labcategory = LabCategory::findOrFail($id)->delete();
        Report::addToLog('  حذف قسم المختبر');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (LabCategory::WhereIn('id', $ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من اقسام المختبر');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
