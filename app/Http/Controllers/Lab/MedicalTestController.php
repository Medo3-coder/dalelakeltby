<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lab\MedicalTest\Store;
use App\Http\Requests\Lab\MedicalTest\Update;
use App\Models\LabCategory;
use App\Traits\ResponseTrait;

class MedicalTestController extends Controller {
    use ResponseTrait;
    public function index() {
        if (request()->ajax()) {
            $tests = provider('lab')->labSubCategoriesHasMany;
            $html  = view('providers_dashboards.lab.tests.table', compact('tests'))->render();
            return response()->json(['html' => $html]);
        }
        $labCategories = LabCategory::where('parent_id', null)->get();
        return view('providers_dashboards.lab.tests.index', compact('labCategories'));
    }

    public function getSubCategory($id) {
        $subCategories = LabCategory::findOrFail($id)->children;
        return response()->json(['html' => view('providers_dashboards.lab.tests._sub_category_options', compact('subCategories'))->render()]);
    }

    public function create() {
        $labCategories = LabCategory::where('parent_id', null)->get();
        return view('providers_dashboards.lab.tests.create', compact('labCategories'));
    }

    public function store(Store $request) {
        provider('lab')->labSubCategoriesHasMany()->updateOrCreate([
            'lab_category_id' => $request->validated()['lab_category_id'],
            'sub_category_id' => $request->validated()['sub_category_id'],
        ], $request->validated());
        return response()->json([
            'msg'    => __('apis.success'),
            'status' => 'success',
            'url'    => route('lab.medicalTests.index'),
        ]);
    }

    public function edit($id) {
        $test          = provider('lab')->labSubCategoriesHasMany()->findOrFail($id);
        $labCategories = LabCategory::where('parent_id', null)->get();
        $subCategories = LabCategory::where('parent_id', $test->lab_category_id)->get();
        return view('providers_dashboards.lab.tests.edit', compact('test', 'labCategories', 'subCategories'));
    }

    public function update(Update $request, $id) {
        $medicine = provider('lab')->labSubCategoriesHasMany()->findOrFail($id);
        $medicine->update($request->validated());
        return response()->json([
            'msg'    => __('apis.updated'),
            'status' => 'success',
            'url'    => route('lab.medicalTests.index'),
        ]);
    }

    public function delete($id) {
        provider('lab')->labSubCategoriesHasMany()->findOrFail($id)->delete();
        return response()->json(['status' => 'success']);
    }

}
