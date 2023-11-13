<?php

namespace App\Http\Controllers\Lab;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lab\MedicalTest\LabTest\Store;
use App\Http\Requests\Lab\MedicalTest\LabTest\Update;
use App\Models\LabCategory;
use App\Models\LabTest;
use App\Traits\ResponseTrait;

class TestController extends Controller {
    use ResponseTrait;
    public function index() {
        if (request()->ajax()) {
            $tests = provider('lab')->labSubCategoriesHasMany()->findOrFail(request()->test)->tests;
            $html  = view('providers_dashboards.lab.tests.test_singles.table', compact('tests'))->render();
            return response()->json(['html' => $html]);
        }
        $labCategories = LabCategory::where('parent_id', null)->get();
        return view('providers_dashboards.lab.tests.test_singles.index', compact('labCategories'));
    }

    public function create() {
        return view('providers_dashboards.lab.tests.test_singles.create');
    }

    public function store(Store $request) {
        $test = LabTest::create($request->validated());
        return response()->json([
            'msg'    => __('apis.success'),
            'status' => 'success',
            'url'    => route('lab.medicalTests.tests.index' ,['test' => $test->sub_category_lab_id]),
        ]);
    }

    public function edit($id) {
        $test = provider('lab')->labSubCategoriesHasMany()->findOrFail(request()->test)->tests()->findOrFail($id);
        return view('providers_dashboards.lab.tests.test_singles.edit', compact('test'));
    }

    public function update(Update $request, $id) {
        $test = provider('lab')->labSubCategoriesHasMany()->findOrFail($request->test)->tests()->findOrFail($id);
        $test->update($request->validated());
        return response()->json([
            'msg'    => __('apis.updated'),
            'status' => 'success',
            'url'    => route('lab.medicalTests.tests.index',['test' => $request->test]),
        ]);
    }

    public function delete($id) {
        $test = provider('lab')->labSubCategoriesHasMany()->findOrFail(request()->test)->tests()->findOrFail($id)->delete();
        return response()->json(['status' => 'success']);
    }

}
