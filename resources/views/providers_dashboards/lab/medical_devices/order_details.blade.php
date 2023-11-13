@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printme,
            #printme *:not(.print-order) {
                visibility: visible !important;
                color: black;
            }

            #printme {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
        }

        .print-order {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>@lang('localize.my_orders')</h6>
                <p>@lang('localize.you_can_see_order_here')</p>
            </div>
            <div class="card-white font-700 print-spe" id="printme">
                <div class="order-d-top">
                    <h6>@lang('localize.order_details')</h6>
                    <img class="print-order" src="{{ asset('dashboard/imgs/Group 83060.png') }}" alt="">
                </div>
                <div class="inner-card">
                    {{-- <div class="small-t">@lang('localize.store_name')</div> --}}
                    <div class="small-t">{{ $order->store->name }}</div>
                    <div class="flex-inner-card">
                        <div class="right-inner-card">
                            <div class="inner-adress">@lang('localize.address') : {{ $order->store->branches->first()->address }}
                            </div>
                            <div class="inner-adress">@lang('localize.phone_number') : {{ $order->store->full_phone }}</div>
                        </div>
                        <div class="left-inner-card">
                            <div class="left-inner-card-top">
                                <div class="left-inner-card-top-r">
                                    <ul>
                                        <li>@lang('localize.bill_num')</li>
                                        <li>{{ $order->order_num }}</li>
                                    </ul>
                                </div>
                                <div class="left-inner-card-top-r">
                                    <ul>
                                        <li>@lang('localize.payment_method')</li>
                                        <li>{{ __('localize.' . $order->payment_type) }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="left-inner-card-top">
                                <div class="left-inner-card-top-r">
                                    <ul>
                                        <li>@lang('localize.order_date')</li>
                                        <li>{{ $order->created_at->toDateTimeString() }}</li>
                                    </ul>
                                </div>
                                <div class="left-inner-card-top-r">
                                    <ul>
                                        <li>{{ __('translation.Saver ID')}}</li>
                                        <li>{{ $order->store->id }}</li>
                                    </ul>
                                </div>
                                {{-- <div class="left-inner-card-top-r">
                                    <ul>
                                        <li>رقم الفاتورة</li>
                                        <li>1334</li>
                                    </ul>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="check-person">@lang('localize.pill_to')</div>
                    <div class="row-name">@lang('localize.lab_manager_name') : {{ $order->lab->name }}</div>
                    <div class="row-name">@lang('localize.lab_name') : {{ $order->lab->lab_name }}</div>
                    <div class="row-name">@lang('localize.lab_address') : {{ $order->lab->address }}</div>
                    <div class="row-name">@lang('localize.phone_number') : {{ $order->lab->full_phone }}</div>
                    <div class="row-name">@lang('localize.email') : {{ $order->lab->email }}</div>
                    <div class="overflowx_auto mb-3 table1-spe mt-5">
                        <table class="table text-center" style="width: 100%">
                            <thead class="table-head">
                                <tr>
                                    <th class="font10">@lang('localize.desc')</th>
                                    <th class="font10">@lang('localize.qty')</th>
                                    <th class="font10">@lang('localize.item_price')</th>
                                    <th class="font10">@lang('localize.price')</th>
                                </tr>
                            </thead>
                            <tbody data-class-name="table-body">

                                @foreach ($order->orderproducts as $product)
                                    <tr>
                                        <td class="font12 text-secondary">
                                            {{ isset($product->offer) ? $product->offer->name : $product->product->name }}
                                        </td>

                                        <td class="font12 text-secondary">{{ $product->qty }}</td>

                                        <td class="font12">
                                            <span class="fontBold text-secondary">{{ $product->price }}
                                                @lang('site.currency')</span>
                                        </td>

                                        <td class="font12">
                                            <span class="fontBold text-secondary">{{ $product->total_price }}
                                                @lang('site.currency')</span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="flex-bttm-card">
                        @if ($order->status == 'accepted')
                            <div class="flex-bttm-card-right">
                                <div class="flex-bttm-spe">
                                    <div class="bttm-text">@lang('localize.prepare_time')</div>
                                    <div class="bttm-text">@lang('localize.expected_delivery_date')</div>
                                </div>
                                <div class="flex-bttm-spe">
                                    <div class="bttm-text">{{ $order->prepare_time }} @lang('localize.day')</div>
                                    <div class="bttm-text">{{ $order->deliver_date }}</div>
                                </div>
                            </div>
                        @endif

                        <div class="flex-bttm-card-right">
                            <div class="flex-bttm-spe">
                                <div class="bttm-text">@lang('localize.sub_total')</div>
                                @if ($order->delivery_price)
                                    <div class="bttm-text">@lang('localize.delivery_value')</div>
                                @endif
                                <div class="bttm-text">@lang('localize.app_commition')</div>
                                <div class="bttm-text">@lang('localize.total_order')</div>
                            </div>
                            <div class="flex-bttm-spe">
                                <div class="bttm-text">{{ $order->total_price }} @lang('site.currency')</div>
                                @if ($order->delivery_price)
                                    <div class="bttm-text">{{ $order->delivery_price }} @lang('site.currency')</div>
                                @endif
                                <div class="bttm-text">{{ $order->admin_commission_amount }} @lang('site.currency')</div>
                                <div class="bttm-text">{{ $order->final_total }} @lang('site.currency')</div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($order->payment_type == 'installment')
                    <h6 class="noborder-btm">@lang('localize.installments')</h6>
                    <div class="overflowx_auto mb-3 table1-spe table-btm">
                        <table class="table text-center" style="width: 100%">
                            <thead class="table-head">
                                <tr>
                                    <th class="font10">@lang('localize.installment_date')</th>
                                    <th class="font10">@lang('localize.duration')</th>
                                    <th class="font10">@lang('localize.price_amount')</th>
                                    <th class="font10">@lang('localize.price_amount')</th>
                                </tr>
                            </thead>
                            <tbody data-class-name="table-body">

                                @foreach ($order->installments as $installment)
                                    <tr>
                                        <td class="font12 text-secondary">
                                            {{ \Carbon\Carbon::parse($installment->date)->format('Y-m-d') }}</td>

                                        <td class="font12 text-secondary">{{ $installment->duration }} @lang('localize.days')
                                        </td>

                                        <td class="font12">
                                            <span class="fontBold text-secondary">{{ $installment->amount }}
                                                @lang('site.currency')</span>
                                        </td>

                                        <td class="font12">
                                            <span class="fontBold text-secondary">@lang('localize.' . $installment->status)</span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-spe-price">
                        @lang('localize.remaining_order_price'): {{ $order->installments->where('status', 'not_paid')->sum('amount') }}
                    </div>
                @endif

            </div>
    </main>
@endsection
@push('js')
    <script>
        document.querySelector('.print-order').onclick = printCertificate;

        function printCertificate() {
            print();
        }
    </script>
@endpush
