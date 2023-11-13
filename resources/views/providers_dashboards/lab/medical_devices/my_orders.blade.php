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
                <h6>@lang('localize.my_orders')</h6>
                <p>@lang('localize.you_can_see_order_here')</p>
            </div>
            <div class="devices-boxs">
                <div class="row">

                    @forelse ($orders as $order)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="device-box">
                                <img src="{{ $order->store->image }}" alt="">
                                <div class="card_foot">
                                    <h6 class="text-center font_bold">{{ $order->store->name }}</h6>
                                    <div class="flex-device">
                                        <div class="right-device">{{ $order->store->name }}</div>
                                        <div class="left-device">@lang('localize.price'): {{ $order->final_total }}</div>
                                    </div>
                                    <div class="flex-device">
                                        <div class="right-device">@lang('localize.discount'): {{ $order->discount }}</div>
                                        <div class="left-device">@lang('localize.coupon'): {{ $order->coupon }}</div>
                                        {{-- <div class="left-device">@lang('localize.bonus'): {{ $order->bonus }}</div> --}}
                                    </div>
                                    <div class="flex-device justify-content-center">
                                        <a href="{{ route('lab.medicalDevices.myOrderDetails', $order->id) }}"
                                            class="link-device  up">@lang('localize.order_details')</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        @include('shared.empity')
                    @endforelse

                </div>

                {{ $orders->links() }}
            </div>
    </main>
@endsection
@push('js')
    {{-- <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> --}}

    {{-- @include('admin.shared.filter_js', ['index_route' => route('lab.rules.index')]); --}}

    @include('shared.cartAjax')
@endpush
