<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\AdditiveRequest;
use App\Http\Requests\Store\Offer\OfferStoreRequest;
use App\Http\Requests\Store\Offer\OfferUpdateRequest;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function auth()
    {
        return provider('store');
    }

    private $data = [];

    public function index()
    {
        Carbon::setLocale(lang());
        $store          = $this->auth();
        if (request()->ajax()) {
            $offers         = $store->offers()->search(request()->searchArray)->paginate(10);
            $html           = view('providers_dashboards.store.offers.table' ,compact('offers'))->render() ;

            return response()->json(['html' => $html]);
        }

        $this->data = [
            'NewOffers'             =>  $store->offers()->where('end_offer', '>', Carbon::now())->count(),
            'PreviousOffers'        =>  $store->offers()->where('end_offer', '<', Carbon::now() )->count(),
            'TotalOffers'           =>  $store->offers()->count(),
        ];

        return view('providers_dashboards.store.offers.index')->with($this->data);
    }

    public function show($id)
    {
        $store          =   $this->auth();
        $offer          =   $store->offers()->findOrFail($id);
        $ids            =   $offer->products()->pluck('product_id');
        $products       =   Product::where('store_id', $store->id)->whereIn('id', $ids)->get();
        Carbon::setLocale(app()->getLocale());


        $this->data = [
            'store'     =>  $store,
            'offer'     =>  $offer,
            'products'  =>  $products,
        ];

        return view('providers_dashboards.store.offers.show')->with($this->data);

    }

    public function productShow($id)
    {
        $store          =   $this->auth();
        $product        =   $store->products()->findOrFail($id);
        $this->data = [
            'product'       =>  $product,
            'store'         =>  $store
        ];
        return view('providers_dashboards.store.offers.product-show')->with($this->data);
    }

    public function create()
    {
        $store          = $this->auth();
        $products       = $store->products()->select('name', 'id')->get();
        $this->data = [
            'store'     =>  $store,
            'products'  =>  $products
        ];
        return view('providers_dashboards.store.offers.create')->with($this->data);
    }

    public function store(OfferStoreRequest $request)
    {
        $store              = $this->auth();
        $offer              = $store->offers()->create($request->except(['product_id']));
        $offer              = $store->offers()->find($offer->id);
        $offer->update(['offer_num'=>Carbon::now()->format('Y') . $offer->id]) ;
        $offer->save();
        $ids = [];

        foreach ($request['product_id'] as $id){
            $ids[] = [
              'product_id'      =>  $id,
              'store_id'        =>  $store->id,
              'offer_id'        =>  $offer->id,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now(),
            ];
        }

        $offer->products()->insert($ids);
        $msg            = __('store.Congratulations!') . ' ' . __('store.Offer added successfully');
        $url            = route('store.offers');
        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>$url]);
    }

    public function edit($id)
    {
        $store          = $this->auth();
        $offer          = $store->offers()->findOrFail($id);
        $products       = $store->products()->select('name', 'id')->get();
        $ids            = $offer->products()->pluck('product_id');

       $this->data = [
            'store'     =>  $store,
            'products'  =>  $products,
            'ids'       =>  $ids,
           'offer'      =>  $offer
        ];

        return view('providers_dashboards.store.offers.edit')->with($this->data);
    }

    public function update(OfferUpdateRequest $request, $id)
    {
        $store              = $this->auth();
        $offer              = $store->offers()->find($id);
        $ids                = [];

        $offer->update($request->except('product_id'));
        $offer->products()->delete();

        foreach ($request['product_id'] as $id){
            $ids[] = [
                'product_id'        =>  $id,
                'store_id'          =>  $store->id,
                'offer_id'          =>  $offer->id,
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now(),
            ];
        }

        $offer->products()->insert($ids);
        $msg            = __('store.Congratulations!') . ' ' . __('store.The offer has been modified successfully');
        $url            = route('store.offers');
        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>$url]);
    }

    public function delete(Request $request)
    {
        $store          = $this->auth();
        $msg            = __('store.Congratulations!') . ' ' . __('store.The offer has been successfully completed');
        $store->offers()->findOrFail($request->id)->delete();
        return response()->json(['status'=>'success', 'msg'=>$msg]);
    }
}
