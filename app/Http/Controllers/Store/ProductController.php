<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Products\AdditionRequest;
use App\Http\Requests\Store\Products\GroupsRequest;
use App\Http\Requests\Store\Products\StoreRequest;
use App\Http\Requests\Store\Products\UpdateRequest;
use App\Models\Feature;
use App\Models\Productfeatureproperity;
use App\Models\Properity;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use UploadTrait;
    public $data = [];

    public function auth()
    {
        return provider('store');
    }

    public function groupRequest()
    {
        return ['in_stock_type','in_stock_sku','in_stock_qty','price' , 'discount_price' , 'from' , 'to'];
    }

    public function checkProductType($product, $type)
    {
        if( $product->type=='multiple' ) {
            $msg    = __('store.Congratulations!') . ' ' ;
            $msg   .= $type == 'add' ? __('store.msg_success_add_product') : __('store.msg_success_edit_product');

            return ['status'=>'success','msg' => $msg, 'url' => route('store.products.features', ['id' => $product->id])];
        }

        $msg = __('store.Congratulations!') . ' ';
        $msg   .= $type == 'add' ? __('store.The product has been added successfully') :  __('store.The product has been modify successfully');

        return ['status'=>'success','msg' => $msg , 'url' => route('store.products')];
    }

    public function images($request, $product)
    {
        $query = [];
        if ($request->hasFile('images')){
            foreach ($request->images as $image){
                $query[] = [
                    'image'             =>  $this->uploadeImage($image, 'products'),
                    'product_id'        =>  $product->id,
                    'created_at'        =>  Carbon::now(),
                    'updated_at'        =>  Carbon::now(),
                ];

            }
            $product->images()->insert($query);
        }

    }
    public function index()
    {
        Carbon::setLocale(app()->getLocale());
        if (request()->ajax()) {

            $store          = $this->auth();
            $products       = $store->products()->search(request()->searchArray)->paginate(10);
            $html           = view('providers_dashboards.store.products.table' ,compact('products'))->render() ;

            return response()->json(['html' => $html]);
        }
        return view('providers_dashboards.store.products.index');
    }

    public function create()
    {
        return view('providers_dashboards.store.products.create');
    }
    public function store(StoreRequest $request)
    {
        $store              = $this->auth();

        $product            = $store->products()->create($request->except($this->groupRequest()));

        $product->update(['product_num'=>Carbon::now()->format('Y') . $product->id]);

        $this->images($request, $product);

        $product->groups()->create($request->only($this->groupRequest()));


        return response()->json($this->checkProductType($product, 'add'));
    }

    public function edit($id)
    {
        $store      = $this->auth();
        $product    = $store->products()->findOrFail($id);
        return view('providers_dashboards.store.products.edit')->with(['store'=>$store, 'product'=>$product]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $store              = $this->auth();
        $product            = $store->products()->findOrFail($id);
        
        if (empty($request['imagesIds']) && $request->hasFile('images') == false){
            $msg = __('store.msg_error_images');
            return response()->json(['status'=>'fail', 'msg'=>$msg]);
        }

        $product->update(['product_num'=>Carbon::now()->format('Y') . $product->id]);

        $product->images()->whereNotIn('id', $request['imagesIds'] ?? [])->delete();

        $this->images($request, $product);

        $product->update($request->except($this->groupRequest() + ['group_one_id']));
        $product->groups()->first()->update($request->only($this->groupRequest()));


        return response()->json($this->checkProductType($product, 'edit'));
    }

    public function show($id)
    {
        $store          =   $this->auth();
        $product        =   $store->products()->findOrFail($id);
        $this->data = [
            'product'       =>  $product,
            'store'         =>  $store
        ];
        return view('providers_dashboards.store.products.show')->with($this->data);
    }

    public function delete(Request $request)
    {
        $store      = $this->auth();
        $product    = $store->products()->findOrFail($request['id']);
        $msg        = __('store.Congratulations!') . ' ' . __('store.The product has been successfully deleted');
        $product->delete();
        return response()->json(['status'=>'success', 'msg'=>$msg]);
    }

    public function features($id)
    {
        $store          = $this->auth();
        $product        = $store->products()->findOrFail($id);
        $features       = Feature::all();
        $properties     = Properity::all();
        $lang           = app()->getLocale();
        return view('providers_dashboards.store.products.features')->with(['product'=>$product, 'features'=>$features, 'properties'=>$properties, 'lang'=>$lang]);
    }

    public function featuresUpdate(Request $request, $id)
    {
        $store      = $this->auth();
        $product    = $store->products()->findOrFail($id);
        $product->productfeatures()->delete() ;

        if ($request->feature_id) {
            foreach ($request->feature_id as $feature) {
                $productfeature = $product->productfeatures()->Create(['feature_id' => $feature]);
                if ($request->proparties) {
                    foreach ($request->proparties[$feature] as  $proparty) {
                        Productfeatureproperity::create(['product_feature_id' => $productfeature->id , 'properity_id' => $proparty ]);
                    }
                }
            }
        }

        return response()->json(['url' => route('store.products.groups' , ['id' => $product->id])]);
    }

    public function featuresDelete(Request $request, $id)
    {
        $store      = $this->auth();
        $product    = $store->products()->findOrFail($id);
        $product->productfeatures()->findOrFail($request['id'])->delete();

        return response()->json(['status'=>'success']);
    }

    public function groups($id)
    {
        $this->data['store']              = $this->auth();
        $this->data['product']            = $this->data['store']->products()->findOrFail($id);
        $this->data['lang ']              = app()->getLocale();
        $this->data['productFeatures']    = $this->data['product']->productfeatures;
        return view('providers_dashboards.store.products.groups')->with($this->data);
    }

    public function groupsUpdate(GroupsRequest $request)
    {
        $store                  =   $this->auth();
        $product                =   $store->products()->findOrFail($request['product_id']);
        $group                  =   $product->groups()->where('id', $request['group_id'])
                                            ->updateOrCreate(['id'=>$request['group_id']],$request->validated() + ['properities'=>$request['ids']]);

        $msg = !empty($request['group_id']) ? __('store.Congratulations!') . ' ' .__('store.The group has been modified successfully')
                                            :__('store.Congratulations!') . ' ' . __('store.The group has been added successfully');

        return response()->json(['status' => 'success', 'id'=>$group['id'], 'msg'=>$msg ]);
    }


    public function groupsDelete(Request $request,$id)
    {
        $store      = $this->auth();
        $product    = $store->products()->findOrFail($id);
        $product->groups()->findOrFail($request['id'])->delete();

        return response()->json(['status'=>'success']);
    }

    public function additions($id)
    {
        $this->data['store']        = $this->auth();
        $this->data['product']      = $this->data['store']->products()->findOrFail($id);
        $this->data['categories']   = $this->data['store']->additives;
        return view('providers_dashboards.store.products.additions')->with($this->data);
    }

    public function additionsUpdate(AdditionRequest $request, $id)
    {
        $store      = $this->auth();
        $product    = $store->products()->findOrFail($id);
        $query      = [];

        $product->additives()->delete();

        if (isset($request['name_ar']) && count($request['name_ar']) > 0){
            foreach ($request['name_ar'] as $key => $value){
                $query[] = [
                    'name'                              =>  json_encode(['ar'=>$request['name_ar'][$key], 'en'=>$request['name_en'][$key], 'kur'=>$request['name_kur'][$key]]),
                    'price'                             =>  $request['price'][$key],
                    'discount_price'                    =>  $request['discount_price'][$key],
                    'product_additive_category_id'      =>  $request['product_additive_category_id'][$key],
                    'product_id'                        =>  $product['id'],
                    'created_at'                        =>  Carbon::now(),
                    'updated_at'                        =>  Carbon::now(),
                ];
            }
            $product->additives()->insert($query);
        }

        $msg = __('store.Changes saved successfully');

        return response()->json(['status'=>'success', 'msg'=>$msg, 'url'=>route('store.products')]);
    }


}
