<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Traits\Report;


class ReservationController extends Controller
{
    public function index($id = null)
    {
        if (request()->ajax()) {
            $type =  request()->segment(3);
            $reservations = Reservation::where('status', $type)->search(request()->searchArray)->paginate(30);
            $html = view('admin.reservations.table', compact('reservations'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.reservations.index');
    }

    public function create()
    {
        return view('admin.reservations.create');
    }

    public function update($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            $reservation->comment = NULL,
            $reservation->rate = NULL
        ]);
        Report::addToLog('حذف تعليق');
        return response()->json(['url' => route('admin.reservations.new')]);
    }

    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
 
        return view('admin.reservations.show', ['reservation' => $reservation]);
    }



    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id)->delete();
        Report::addToLog('  حذف الحجز');
        return response()->json(['id' => $id]);
    }

    public function destroyAll(Request $request)
    {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (Reservation::WhereIn('id', $ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من الحجوزات');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}
