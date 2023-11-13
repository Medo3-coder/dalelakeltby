@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')
    <main class="main-sec" id="main">
        {{--  @dd($offer->products)  --}}
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">
                    <h6>@lang('localize.buy_equipments')</h6>
                    <p>@lang('localize.you_can_buy_equipments')</p>
                </div>



                @if (
                    !in_array(
                        $offer->id,
                        provider(request()->segment(1))->carts()->pluck('offer_id')->toArray()))
                    <button data-add-cart-url="{{ route('lab.cart.addOffer', $offer->id) }}" class="test-result up test-btn"
                        data-toggle="modal" data-target="#searchMODEL">
                        <i class="fa-solid fa-cart-plus"></i>
                        @lang('localize.add_offer_to_cart')
                    </button>
                @else
                    <button class="left-device add-btn">
                        <i class="fa fa-check"></i>
                    </button>
                @endif



            </div>
            <div class="card-white spe-pad">
                <div class="card-top">
                    <h5 class="card-top-right font_bold">{{ __('store.offer_name') }} : {{ $offer->name }}</h5>
                    <div class="quentity"> {{ __('store.end_offer') }} : <span>{{ Carbon\Carbon::parse($offer->end_offer)->translatedFormat('j F Y') }}</span></div>
                    <div class="quentity"> {{ __('store.The number of items available') }} : <span>{{ count($offer->products) . '' }}</span></div>
                    <div class="quentity">{{ __('store.offer price') }} : <span>{{ $offer->offer_price. ' ' . __('store.Dinar') }}</span></div>
                    @if(!empty($offer->offer_discount))
                        <div class="quentity">{{ __('store.Discount') }} : <span>{{ $offer->offer_discount. ' ' . __('store.Dinar') }}</span></div>
                    @endif
                </div>
                <div class="img-cont-card text-center"><img src="{{ $offer->image }}" alt=""></div>




                {{--  <div class="card-top-left">
                    <div class="quentity">@lang('localize.price') <span> {{ $offer->products->product->groupOne()?->price }}
                            @lang('localize.package')</span></div>
                    <div class="card-price">@lang('localize.dicount_amount'): 30 @lang('site.currency')</div>
                </div>  --}}
            </div>


            <div class="card-top mt-4">
                <h5 class="card-top-right font_bold">@lang('localize.products')</h5>

            </div>


            @foreach ($offer->products as $offerProduct)
                <div class="box-for-product mb-3">
                    <div class="box-for-product-right">
                        <img src="{{ $offerProduct->product->image }}" alt="" />
                    </div>
                    <div class="box-for-product-left">
                        <div class="box-for-product-left-f-top mb-3">
                            <h6 class="font-bold no-border-bottom padding-btm-no">
                                {{ $offerProduct->product->name }}
                            </h6>

                            <div class="center-flex">
                                {{--  <div class="line-spe-div">@lang('localize.number_in_order') : {{$offerProduct->product->groupOne()?->in_stock_qty}} @lang('localize.package')</div>  --}}
                                <div class="line-spe-div">@lang('localize.price') :
                                    {{ $offerProduct->product->groupOne()?->price }} @lang('site.currency')</div>
                            </div>

                        </div>
                        <div class="par-code"> {{ $offerProduct->product->groupOne()?->id }}</div>
                        {{--  <div class="all-spans">
                            <span>المنتجات:</span>
                            <span>اسم المنتج</span>
                            <span>اسم المنتج</span>
                            <span>اسم المنتج</span>
                        </div>  --}}
                        <div class="decive-job">
                            <span class="hegh-span"> نبذة عن المنتج:</span>
                            <p class="color-gray">
                                قياس هذا النص هو مثال لنص يمكن ان يستبدل في نفس المساحة هذا
                                يستبدل في نفس المساحة هذايستبدل في نفس المساحة هذاالنص هذا
                                للنبث السكر
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach



    </main>


    <!-- Modal 2 -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="">
                    <div class="font_bold don-t">@lang('localize.added_to_cart') </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">تم</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('shared.cartAjax')
@endpush
