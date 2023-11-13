<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\chranicdiseases\Store;
use App\Http\Requests\Admin\chranicdiseases\Update;
use App\Models\ChranicDisease;
use App\Traits\Report;


class ChranicDiseasesController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $chranicdiseases = ChranicDisease::search(request()->searchArray)->paginate(30);
            $html = view('admin.chranicdiseases.table' ,compact('chranicdiseases'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.chranicdiseases.index');
    }

    public function create()
    {
        return view('admin.chranicdiseases.create');
    }


    public function store(Store $request)
    {
        ChranicDisease::create($request->validated());
        Report::addToLog('  اضافه المرض المزن') ;
        return response()->json(['url' => route('admin.chranicdiseases.index')]);
    }
    public function edit($id)
    {
        $chranicdiseases = ChranicDisease::findOrFail($id);
        return view('admin.chranicdiseases.edit' , ['chranicdiseases' => $chranicdiseases]);
    }

    public function update(Update $request, $id)
    {
        $chranicdiseases = ChranicDisease::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل المرض المزن') ;
        return response()->json(['url' => route('admin.chranicdiseases.index')]);
    }

    public function show($id)
    {
        $chranicdiseases = ChranicDisease::findOrFail($id);
        return view('admin.chranicdiseases.show' , ['chranicdiseases' => $chranicdiseases]);
    }
    public function destroy($id)
    {
        $chranicdiseases = ChranicDisease::findOrFail($id)->delete();
        Report::addToLog('  حذف المرض المزن') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (ChranicDisease::WhereIn('id',$ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من الامراض المزمنة') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
