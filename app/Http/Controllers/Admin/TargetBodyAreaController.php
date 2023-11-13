<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\targetbodyareas\Store;
use App\Http\Requests\Admin\targetbodyareas\Update;
use App\Models\TargetBodyArea ;
use App\Traits\Report;


class TargetBodyAreaController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $targetbodyareas = TargetBodyArea::search(request()->searchArray)->paginate(30);
            $html = view('admin.targetbodyareas.table' ,compact('targetbodyareas'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.targetbodyareas.index');
    }

    public function create()
    {
        return view('admin.targetbodyareas.create');
    }


    public function store(Store $request)
    {
        TargetBodyArea::create($request->validated());
        Report::addToLog('  اضافه المنطقة المستهدفة') ;
        return response()->json(['url' => route('admin.targetbodyareas.index')]);
    }
    public function edit($id)
    {
        $targetbodyarea = TargetBodyArea::findOrFail($id);
        return view('admin.targetbodyareas.edit' , ['targetbodyarea' => $targetbodyarea]);
    }

    public function update(Update $request, $id)
    {
        $targetbodyarea = TargetBodyArea::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل المنطقة المستهدفة') ;
        return response()->json(['url' => route('admin.targetbodyareas.index')]);
    }

    public function show($id)
    {
        $targetbodyarea = TargetBodyArea::findOrFail($id);
        return view('admin.targetbodyareas.show' , ['targetbodyarea' => $targetbodyarea]);
    }
    public function destroy($id)
    {
        $targetbodyarea = TargetBodyArea::findOrFail($id)->delete();
        Report::addToLog('  حذف المنطقة المستهدفة') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (TargetBodyArea::WhereIn('id',$ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من المناطق المستهدقة') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
