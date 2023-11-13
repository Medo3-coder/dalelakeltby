<?php

namespace App\Http\Controllers\Admin;

use App\Builders\Input;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\apppages\Store;
use App\Http\Requests\Admin\apppages\Update;
use App\Models\AppPage;
use App\Traits\Report;
use Illuminate\Http\Request;

class AppPageController extends Controller {
    private function inputs($options = null) {
        return [
            'image'       => Input::imageInput()->build(),
        ];
    }

    public function index($id = null) {
        if (request()->ajax()) {
            $apppages = AppPage::search(request()->searchArray)->paginate(30);
            $html  = view('admin.apppages.table', compact('apppages'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.apppages.index');
    }

    public function create() {
        // $users = User::get();
        return view('admin.apppages.create', ['inputs' => $this->inputs([
            // 'users' => $users
        ])]);
    }

    public function store(Store $request) {
        AppPage::create($request->validated());
        Report::addToLog('  اضافه صفحة التطبيق');
        return response()->json(['url' => route('admin.apppages.index')]);
    }
    public function edit($id) {
        $apppage = AppPage::findOrFail($id);
        // $files = $apppage->files;
        // $users = User::get();
        return view('admin.apppages.edit', ['item' => $apppage, 'inputs' => $this->inputs([
            // 'users' => $users,
            // 'files' => $files
        ])]);
    }

    public function update(Update $request, $id) {
        $apppage = AppPage::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل صفحة التطبيق');
        return response()->json(['url' => route('admin.apppages.index')]);
    }

    public function show($id) {
        $apppage = AppPage::findOrFail($id);
        // $files = $apppage->files;
        // $users = User::get();
        return view('admin.apppages.show', ['item' => $apppage, 'inputs' => $this->inputs([
            // 'users' => $users,
            // 'files' => $files
        ])]);
    }
    public function destroy($id) {
        $apppage = AppPage::findOrFail($id)->delete();
        Report::addToLog('  حذف صفحة التطبيق');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (AppPage::WhereIn('id', $ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من صفحات التطبيق');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
