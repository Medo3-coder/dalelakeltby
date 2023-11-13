<?php

namespace App\Http\Controllers\Admin;

use App\Builders\Input;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\sitefeatures\Store;
use App\Http\Requests\Admin\sitefeatures\Update;
use App\Models\SiteFeature;
use App\Traits\Report;
use Illuminate\Http\Request;

class SiteFeatureController extends Controller {
    private function inputs($options = null) {
        return [
            'image'       => Input::imageInput()->build(),
            'title'       => Input::createArEnInput(__('admin.name_ar'), __('admin.name_en'), __('admin.name_kur'))->build(),
            'description' => Input::createArEnTextarea(__('admin.description_ar'), __('admin.description_en'), __('admin.description_kur'))->colMd(12)->build(),
        ];
    }

    public function index($id = null) {
        if (request()->ajax()) {
            $sitefeatures = SiteFeature::search(request()->searchArray)->paginate(30);
            $html         = view('admin.sitefeatures.table', compact('sitefeatures'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.sitefeatures.index');
    }

    public function create() {
        return view('admin.sitefeatures.create', ['inputs' => $this->inputs([
            // 'users' => $users
        ])]);
    }

    public function store(Store $request) {
        SiteFeature::create($request->validated());
        Report::addToLog('  اضافه ميزة الموقع');
        return response()->json(['url' => route('admin.sitefeatures.index')]);
    }
    public function edit($id) {
        $sitefeature = SiteFeature::findOrFail($id);
        return view('admin.sitefeatures.edit', ['item' => $sitefeature, 'inputs' => $this->inputs()]);
    }

    public function update(Update $request, $id) {
        $sitefeature = SiteFeature::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل ميزة الموقع');
        return response()->json(['url' => route('admin.sitefeatures.index')]);
    }

    public function show($id) {
        $sitefeature = SiteFeature::findOrFail($id);
        return view('admin.sitefeatures.show', ['item' => $sitefeature, 'inputs' => $this->inputs()]);
    }
    public function destroy($id) {
        $sitefeature = SiteFeature::findOrFail($id)->delete();
        Report::addToLog('  حذف ميزة الموقع');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (SiteFeature::WhereIn('id', $ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من مميزات الموقع');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
