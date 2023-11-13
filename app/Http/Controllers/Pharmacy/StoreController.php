<?php

namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller {

    public function index() {
        if (request()->ajax()) {
            $stores = Store::whereHas('products')->where('parent_id', null)->search(request()->searchArray)->paginate(30);
            $html   = view('providers_dashboards.pharmacy.stores.body', compact('stores'))->render();
            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.pharmacy.stores.index');
    }

    public function details($id) {
        $store    = Store::with('offers', 'products', 'branches', 'images', 'products', 'products')->findOrFail($id);
        $offers   = $store->offers()->valid()->get();
        $products = $store->products()->where(['available'=>'true'])->get();
        return view('providers_dashboards.pharmacy.stores.details', get_defined_vars());
    }

    public function products(Request $request) {
        $products = Store::findOrFail($request->store)->products()->where([ 'available'=>'true'])->orderBy('updated_at' ,'desc')->paginate(16);
        return view('providers_dashboards.pharmacy.stores.all_products', compact('products'));
    }
}
