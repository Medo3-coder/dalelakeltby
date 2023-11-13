<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\bloodtypes\Store;
use App\Http\Requests\Admin\bloodtypes\Update;
use App\Models\BloodType ;
use App\Traits\Report;


class BloodTypeController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $bloodtypes = BloodType::search(request()->searchArray)->paginate(30);
            $html = view('admin.bloodtypes.table' ,compact('bloodtypes'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.bloodtypes.index');
    }

    public function create()
    {
        return view('admin.bloodtypes.create');
    }


    public function store(Store $request)
    {
        BloodType::create($request->validated());
        Report::addToLog('  اضافه فصائل_الدم') ;
        return response()->json(['url' => route('admin.bloodtypes.index')]);
    }
    public function edit($id)
    {
        $bloodtype = BloodType::findOrFail($id);
        return view('admin.bloodtypes.edit' , ['bloodtype' => $bloodtype]);
    }

    public function update(Update $request, $id)
    {
        $bloodtype = BloodType::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل فصائل_الدم') ;
        return response()->json(['url' => route('admin.bloodtypes.index')]);
    }

    public function show($id)
    {
        $bloodtype = BloodType::findOrFail($id);
        return view('admin.bloodtypes.show' , ['bloodtype' => $bloodtype]);
    }
    public function destroy($id)
    {
        $bloodtype = BloodType::findOrFail($id)->delete();
        Report::addToLog('  حذف فصائل_الدم') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (BloodType::WhereIn('id',$ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من فصيله_الدم') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
