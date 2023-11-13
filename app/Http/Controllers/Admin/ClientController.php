<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Client\Store;
use App\Http\Requests\Admin\Client\Update;
use App\Jobs\Notify;
use App\Mail\SendMail;
use App\Models\BloodType;
use App\Models\ChranicDisease;
use App\Models\ChranicDiseaseUser;
use App\Models\Complaint;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NotifyUser;
use App\Notifications\BlockUser;
use App\Traits\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Mail;

class ClientController extends Controller {

    public function index($id = null) {
        if (request()->ajax()) {
            $rows = User::search(request()->searchArray)->paginate(30);
            $html = view('admin.clients.table', compact('rows'))->render();
            return response()->json(['html' => $html]);
        }
        return view('admin.clients.index');
    }

    public function create() {
        $chranicdiseases = ChranicDisease::get();
        $bloodTypes = BloodType::get();
        return view('admin.clients.create' , compact('chranicdiseases' , 'bloodTypes'));
    }

    public function store(Store $request) {
        // dd(request()->all());
        $user =  User::create($request->except('chranic_disease_id'));
        $user->diseases()->attach($request->chranic_disease_ids);
        Report::addToLog('  اضافه مستخدم');
        return response()->json(['url' => route('admin.clients.index')]);
    }

    public function edit($id) {
        $row = User::findOrFail($id);
        $disease = $row->diseasesHasMany->pluck('chranic_disease_id');
        $chranicdiseases = ChranicDisease::get();
        $bloodTypes = BloodType::get();
        return view('admin.clients.edit', ['row' => $row , 'chranicdiseases'=>$chranicdiseases , 'bloodTypes'=>$bloodTypes , "disease" => $disease]);
    }

    public function update(Update $request, $id) {
        $user = User::find($id);
        $user->update($request->except('chranic_disease_id'));
        $user->diseases()->detach();
        $user->diseases()->attach($request->chranic_disease_ids);
        Report::addToLog('  تعديل مستخدم');
        return response()->json(['url' => route('admin.clients.index')]);
    }

    public function show($id) {
        $row = User::findOrFail($id);
        return view('admin.clients.show', ['row' => $row]);
    }
    public function showfinancial($id) {
        $complaints = Complaint::where('user_id', $id)->paginate(10);
        return view('admin.complaints.user_complaints', ['complaints' => $complaints]);
    }

    public function showorders($id) {
        $orders = Order::where('user_id', $id)->paginate(10);
        return view('admin.clients.orders', ['orders' => $orders]);
    }


    public function destroy($id) {
        $user = User::findOrFail($id)->delete();
        Report::addToLog('  حذف مستخدم');
        return response()->json(['id' => $id]);
    }

    public function block(Request $request) {
        $user = User::findOrFail($request->id);
        $user->update(['is_blocked' => !$user->is_blocked]);
        if($user->is_blocked){
            Notification::send($user, new BlockUser($request->all()));
        }
        return response()->json(['message' => $user->refresh()->is_blocked == 1 ? __('admin.client_blocked') :  __('admin.client_unblocked')]);
    }

    public function notify(Request $request) {
        if ($request->notify == 'notify') {
            if ('all' == $request->id) {
                $clients = User::latest()->get();
            } else {
                $clients = User::findOrFail($request->id);
            }
            Notification::send($clients, new NotifyUser($request->all()));
        } else {
            if ('all' == $request->id) {
                $mails = User::where('email', '!=', null)->get()->pluck('email')->toArray();
            } else {
                $mails = User::findOrFail($request->id)->email;
            }
            Mail::to($mails)->send(new SendMail(['title' => 'اشعار اداري', 'message' => $request->message]));
        }
        return response()->json();
    }

    public function destroyAll(Request $request) {
        $requestIds = json_decode($request->data);

        foreach ($requestIds as $id) {
            $ids[] = $id->id;
        }
        if (User::whereIn('id', $ids)->get()->each->delete()) {
            Report::addToLog('  حذف العديد من المستخدمين');
            return response()->json('success');
        } else {
            return response()->json('failed');
        }
    }
}