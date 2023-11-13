<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\AdditiveRequest;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function auth()
    {
        return provider('store');
    }

    public function index()
    {
        Carbon::setLocale(app()->getLocale());
        if (request()->ajax()) {
            $store          = $this->auth();
            $additives      = $store->additives()->search(request()->searchArray)->paginate(10);
            $html           = view('providers_dashboards.store.categories.table' ,compact('additives'))->render() ;

            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.store.categories.index');
    }

    public function create()
    {
        return view('providers_dashboards.store.categories.create');
    }

    public function store(AdditiveRequest $request)
    {
        $store          = $this->auth();
        $store->additives()->create($request->validated());
        $msg            = __('store.Congratulations!') . ' ' . __('store.The section has been added successfully');
        $url            = route('store.categories');
        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>$url]);
    }

    public function edit($id)
    {
        $store          = $this->auth();
        $additive       = $store->additives()->findOrFail($id);

        return view('providers_dashboards.store.categories.edit', compact('store', 'additive'));
    }

    public function update(AdditiveRequest $request, $id)
    {
        $store          = $this->auth();
        $store->additives()->findOrFail($id)->update($request->validated());
        $msg            = __('store.Congratulations!') . ' ' . __('store.The section has been modified successfully');
        $url            = route('store.categories');
        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>$url]);
    }

    public function delete(Request $request)
    {
        $store          = $this->auth();
        $msg            = __('store.Congratulations!') . ' ' . __('store.The section has been deleted successfully');
        $store->additives()->findOrFail($request->id)->delete();
        return response()->json(['status'=>'success', 'msg'=>$msg]);
    }
}
