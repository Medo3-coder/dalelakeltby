@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/select2.css" />
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/jquery.fancybox.min.css" />


@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">
                    <h6>{{ $product->category_type == 'medicine' ? __('store.Medication details') : __('store.Device details') }}</h6>
                </div>
                <div class="waiting">
                    <a
                            href="{{ route('store.products.edit', $product->id) }}"
                            class="all-products font-17"
                    >
                        <img src="{{ asset('/') }}dashboard/imgs/Group 83036.png" alt="" />
                        {{ $product->category_type == 'medicine' ? __('store.Medication adjustment') : __('store.Device modification') }}
                    </a>
                </div>
            </div>
            <div class="card-white spe-pad">
                <div class="card-top mt-4">
                    <h5 class="card-top-right font_bold">{{ $product->category_type == 'medicine' ? __('store.medicament name') : __('store.the device name') }} : {{ $product->name }}</h5>
                    <div class="card-top-left">
                        <div class="quentity">{{ __('store.incoming quantity') }} : <span>{{ $product->groupOne()->in_stock_qty . ' ' . __('store.Package') }}</span></div>
                        <div class="card-price">{{ __('store.price') . ' : '  }} {!! $product->display_price() !!}</div>
                    </div>
                </div>
                <div class="text-center img-spe-fb">
                    <img
                            class="center-small mt-3"
                            src="{{ $product->image }}"
                            alt=""
                    />
                </div>
                <div class="par-code font-700 font-16 mt-4 mb-1"> {{ $product->category_type == 'medicine' ? __('store.drug code') : __('store.device code') }} : {{ $product->product_num }}</div>


                    @if($product->category_type == 'medicine')
                    <div class="all-spans font-700 font-16">
                            <span>{{ __('store.Active substances') }} : </span>
                            <span>{{ $product->effective_material }}</span>
                        </div>
                    @endif
                <div class="decive-job font-700 font-16">
                    <span class="hegh-span"> {{ $product->category_type == 'medicine' ? __('store.medicine description') : __('store.Device description') }} :  </span>
                    <p class="color-gray">
                        {{ $product->desc }}
                    </p>
                </div>
                <div class="font-16 font-700 mb-3">{{ __('store.internal content images') }} :</div>

                <div class="row">
                    @forelse($product->images as $image)
                        <div class="col-md-6 col-12 spe-for-img2 mb-3">
                            <img
                                    src="{{ $image->image }}"
                                    alt=""
                            />
                        </div>
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
    </main>


@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>

    <script src="{{ asset('/') }}dashboard/js/select2.js"></script>
    <script src="{{ asset('/') }}dashboard/js/jquery.fancybox.min.js"></script>



    @include('providers_dashboards.store.includes.js.formAjax')

@endpush
