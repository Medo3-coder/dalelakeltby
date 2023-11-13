<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\orders\Store;
use App\Http\Requests\Admin\orders\Update;
use App\Models\Order;
use App\Traits\Report;


class OrderController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $status =  request()->segment(3);
            if ($status == "all") {
                $orders = Order::search(request()->searchArray)->paginate(30);
            } else {
                $orders = Order::where('status', $status)->search(request()->searchArray)->paginate(30);
            }
            $html = view('admin.orders.table', compact('orders'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.orders.index');
    }

    public function create()
    {
        return view('admin.orders.create');
    }


    public function store(Store $request)
    {
        Order::create($request->validated());
        Report::addToLog('  اضافه الطلب');
        return response()->json(['url' => route('admin.orders.index')]);
    }
 

    public function update(Update $request, $id)
    {
        $order = Order::findOrFail($id)->update($request->validated());
        Report::addToLog('  تعديل الطلب');
        return response()->json(['url' => route('admin.orders.index')]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $orderGroups        =   $order->orderproducts()->orderBy('offer_id', 'DESC')->get();
        
        return view('admin.orders.show', ['order' => $order, 'orderGroups'=>$orderGroups]);
    }
    public function destroy($id)
    {
        $order = Order::findOrFail($id)->delete();
        Report::addToLog('  حذف الطلب');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Order::WhereIn('id', $ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من الطلبات');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
