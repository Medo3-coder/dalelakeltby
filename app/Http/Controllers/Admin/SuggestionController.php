<?php

namespace App\Http\Controllers\Admin;

use App\Builders\Input;
use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use App\Traits\Report;
use Illuminate\Http\Request;

class SuggestionController extends Controller {
    private function inputs($options = null) {
        return [
            // 'name'    => Input::createInput('text', __('admin.name' ))->colMd(12)->build(),
            'message' => Input::textareaInput(__('admin.message'))->colMd(12)->build(),
        ];
    }

    public function index($id = null) {
        if (request()->ajax()) {
            $suggestions = Suggestion::search(request()->searchArray)->paginate(30);
            $html        = view('admin.suggestions.table', compact('suggestions'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.suggestions.index');
    }

    public function show($id) {
        $suggestion = Suggestion::findOrFail($id);
        return view('admin.suggestions.show', ['item' => $suggestion, 'inputs' => $this->inputs()]);
    }
    public function destroy($id) {
        $suggestion = Suggestion::findOrFail($id)->delete();
        Report::addToLog('  حذف مقترح');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Suggestion::WhereIn('id', $ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من المقترحات');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
