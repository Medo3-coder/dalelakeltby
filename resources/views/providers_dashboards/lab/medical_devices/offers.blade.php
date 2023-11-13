@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>@lang('localize.buy_equipments')</h6>
                <p>@lang('localize.you_can_buy_equipments')</p>
            </div>
            <div class="devices-boxs">
                <div class="row">

                    @forelse ($offers as $offer)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="device-box">
                                <img src="{{ $offer->image }}" alt="">
                                <div class="card_foot">
                                    <h6 class="text-center font_bold">{{ $offer->name }}</h6>
                                    <div class="flex-device">
                                        <div class="right-device">{{ $offer->store->name }}</div>
                                        <div class="left-device">@lang('localize.price'): {{ $offer->price }}</div>
                                    </div>
                                    <div class="flex-device">
                                        <div class="right-device">@lang('localize.discount'): {{ $offer->discount }}</div>
                                        {{-- <div class="left-device">@lang('localize.coupon'): 400</div> --}}
                                        <div class="left-device">@lang('localize.bonus'): {{ $offer->bonus }}</div>
                                    </div>
                                    <div class="flex-device">
                                        <a href="{{ route('lab.medicalDevices.offerDetails', $offer->id) }}"
                                            class="link-device up">@lang('localize.more')</a>

                                        @if (
                                            !in_array(
                                                $offer->id,
                                                provider(request()->segment(1))->carts()->pluck('offer_id')->toArray()))
                                            <button class="left-device add-btn"
                                                data-add-cart-url="{{ route('lab.cart.addOffer', $offer->id) }}">
                                                <i class="fa-solid fa-cart-plus"></i>
                                                @lang('localize.add_to_cart')
                                            </button>
                                        @else
                                            <button class="left-device add-btn">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        @include('shared.empity')
                    @endforelse

                </div>

                {{ $offers->links() }}
            </div>
    </main>
@endsection
@push('js')
    {{-- <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}

    {{-- @include('admin.shared.filter_js', ['index_route' => route('lab.rules.index')]); --}}

    @include('shared.cartAjax')
@endpush
