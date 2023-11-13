<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\sitemessages\Store;
use App\Http\Requests\Admin\sitemessages\Update;
use App\Models\SiteMessage ;
use App\Traits\Report;


class SiteMessageController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $sitemessages = SiteMessage::search(request()->searchArray)->paginate(30);
            $html = view('admin.sitemessages.table' ,compact('sitemessages'))->render() ;
            return response()->json(['html' => $html]);
        }
        return view('admin.sitemessages.index');
    }

    // public function create()
    // {
    //     return view('admin.sitemessages.create');
    // }


    // public function store(Store $request)
    // {
    //     SiteMessage::create($request->validated());
    //     Report::addToLog('  اضافه رسالة الموقع') ;
    //     return response()->json(['url' => route('admin.sitemessages.index')]);
    // }
    // public function edit($id)
    // {
    //     $sitemessage = SiteMessage::findOrFail($id);
    //     return view('admin.sitemessages.edit' , ['sitemessage' => $sitemessage]);
    // }

    // public function update(Update $request, $id)
    // {
    //     $sitemessage = SiteMessage::findOrFail($id)->update($request->validated());
    //     Report::addToLog('  تعديل رسالة الموقع') ;
    //     return response()->json(['url' => route('admin.sitemessages.index')]);
    // }

    public function show($id)
    {
        $sitemessage = SiteMessage::findOrFail($id);
        return view('admin.sitemessages.show' , ['sitemessage' => $sitemessage]);
    }
    public function destroy($id)
    {
        $sitemessage = SiteMessage::findOrFail($id)->delete();
        Report::addToLog('  حذف رسالة الموقع') ;
        return response()->json(['id' =>$id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);
        
        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (SiteMessage::WhereIn('id',$ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من رسايل الموقع') ;
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
