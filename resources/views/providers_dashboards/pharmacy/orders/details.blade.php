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

            <div class="card-white spe-pad small-card">
                    @if (in_array($order->status , ['pending', 'accepted', 'prepared']))
                    <div class="small-right">
                        <div class="felex-small">
                            <div class="right-felex">
                                <div
                                    class="circle-spe {{ in_array($order->status, ['pending', 'accepted', 'prepared']) == true ? 'activate-spe' : '' }}">
                                    1</div>
                                <div class="detail-spe font-bold">{{ __('store.under approval') }}</div>
                            </div>
                            <div
                                class="left-felex {{ in_array($order->status, ['accepted', 'prepared']) == true ? 'activate-spe' : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="small-middle">
                        <div class="felex-small">
                            <div class="right-felex">
                                <div
                                    class="circle-spe {{ in_array($order->status, ['accepted', 'prepared']) == true ? 'activate-spe' : '' }}">
                                    2</div>
                                <div class="detail-spe">{{ __('store.Accepted request') }}</div>
                            </div>
                            <div
                                class="left-felex {{ in_array($order->status, ['prepared']) == true ? 'activate-spe' : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="small-left">
                        <div class="felex-small">
                            <div class="right-felex">
                                <div
                                    class="circle-spe {{ in_array($order->status, ['prepared']) == true ? 'activate-spe' : '' }}">
                                    3</div>
                                <div class="detail-spe">{{ __('store.The request has been processed') }}</div>
                            </div>
                        </div>
                    </div>
                    @else
                    @lang('localize.' . $order->status)
                    @endif
                </div>

            <div class="card-white font-700 print-spe" id="printme">
                <div class="order-d-top">
                    <h6>@lang('localize.order_details')</h6>
                    <img class="print-order" src="{{ asset('dashboard/imgs/Group 83060.png') }}" alt="">
                </div>
                <div class="inner-card">
                    <div class="small-t">@lang('localize.store_name') : {{ $store->name }}</div>
                    <div class="flex-inner-card">
                        <div class="right-inner-card">
                            <div class="inner-adress">@lang('localize.address') : {{ $store->firstBranch()->address }}</div>
                            <div class="inner-adress">@lang('localize.phone_number') : {{ $store->fullPhone }}</div>
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
                                        <li>{{ __('store.payment method') }}</li>
                                        <li>{{ $order->paymentTypeTrans }}</li>
                                        @if($order->payment_type == 'installment')
                                            <li class="flex-li">
                                                <div>{{ $order->final_total == 0 ? 0 : number_format($order->final_total / $order->installment_number, 2)  }}</div>
                                                <div>{{ __('store.installment_days', ['num'=>$order->installment_days]) }}</div>
                                            </li>
                                        @endif

                                    </ul>
                                </div>

                            </div>

                            <div class="left-inner-card-top">
                                <div class="left-inner-card-top-r">
                                    <ul>
                                        <li>{{ __('store.The date of order') }}</li>
                                        <li>{{ Carbon\Carbon::parse($order->created_at)->translatedFormat('j F Y') }}</li>
                                    </ul>
                                </div>
                                <div class="left-inner-card-top-r">
                                    <ul>
                                        <li>{{ __('translation.delivery_method') }}</li>
                                        <li>{{ __('store.' . $order->receiving_method) }}</li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="check-person">@lang('localize.pill_to')</div>
                    <div class="row-name">@lang('localize.pharmacy_manager_name') : {{ $order->pharmacist->name }}</div>
                    {{--  <div class="row-name">@lang('localize.pharmacy_name') : {{ $order->pharmacist->lab_name }}</div>  --}}
                    <div class="row-name">@lang('localize.pharmacy_address') : {{ $order->address }}</div>
                    <div class="row-name">@lang('localize.phone_number') : {{ $order->pharmacist->full_phone }}</div>
                    <div class="row-name">@lang('localize.email') : {{ $order->pharmacist->email }}</div>
                    <div class="overflowx_auto mb-3 table1-spe mt-5">
                        <table class="table text-center" style="width: 100%">
                            <thead class="table-head">
                            <tr>
                                <th class="font10">{{ __('store.name') }}</th>
                                <th class="font10">{{ __('store.Type') }}</th>
                                <th class="font10">{{ __('store.Quantity') }}</th>
                                <th class="font10">{{ __('store.unit price') }}</th>
                                <th class="font10">{{ __('store.the amount') }}</th>
                            </tr>
                            </thead>
                            <tbody data-class-name="table-body">
                            @foreach($orderGroups as $group)
                                <tr>
                                    @if($group->offer_id != null)
                                        <td class="font12 text-secondary">{{ optional($group->offer)->name }}</td>
                                        <td class="font12 text-secondary">عرض</td>
                                    @elseif(optional($group->product)->category_type == 'equipment')
                                        <td class="font12 text-secondary">{{ optional($group->product)->name }}</td>
                                        <td class="font12 text-secondary">{{ __('store.equipment') }}</td>
                                    @else
                                        <td class="font12 text-secondary">{{ optional($group->product)->name }}</td>
                                        <td class="font12 text-secondary">{{ __('store.medicine') }}</td>
                                    @endif
                                    <td class="font12 text-secondary">{{ $group->qty }}</td>

                                    <td class="font12">
                                        <span class="fontBold text-secondary">{{ $group->price . ' ' . __('store.Dinar') }}</span>
                                    </td>

                                    <td class="font12">
                                        <span class="fontBold text-secondary">{{ $group->total_price  . ' ' . __('store.Dinar') }}</span>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>

                    <div class="flex-bttm-card">
                        <div class="flex-bttm-card-right">
                            @if($order->status != 'pending' && !empty($order->installment_days) && !empty($order->installment_number))
                                <div class="flex-bttm-spe">
                                    <div class="bttm-text">{{ __('store.prepare_time') }}</div>
                                    <div class="bttm-text">{{ __('store.Possible delivery time') }}</div>
                                </div>
                                <div class="flex-bttm-spe">
                                    <div class="bttm-text">{{ $order->prepare_time }}</div>
                                    <div class="bttm-text">{{ Carbon\Carbon::parse($order->deliver_date)->translatedFormat('j F Y') }}</div>
                                </div>
                            @endif
                        </div>
                        <div class="flex-bttm-card-right">
                            <div class="flex-bttm-spe">
                                <div class="bttm-text">{{ __('store.subtotal') }}</div>
                                @if(!empty($order->discount))
                                    <div class="bttm-text">{{ __('store.Total after discount') }}</div>
                                @endif

                                @if($order->receiving_method == 'by_delegate')
                                    <div class="bttm-text">{{ __('store.Delivery value') }}</div>
                                @endif
                                <div class="bttm-text">{{ __('store.Application commission') }}</div>
                                <div class="bttm-text">{{ __('store.Added tax rate') }}</div>
                                <div class="bttm-text">{{ __('store.value added tax') }}</div>
                                <div class="bttm-text">{{ __('store.total order') }}</div>
                            </div>
                            <div class="flex-bttm-spe">
                                @if(!empty($order->discount))
                                    <div class="bttm-text">{{ ($order->total_price + $order->discount) . ' ' . __('store.Dinar') }}</div>
                                @endif
                                <div class="bttm-text">{{ $order->total_price . ' ' . __('store.Dinar') }}</div>
                                @if($order->receiving_method == 'by_delegate')
                                    <div class="bttm-text">{{ $order->delivery_price . ' ' . __('store.Dinar') }}</div>
                                @endif
                                <div class="bttm-text">{{ (int)$order->admin_commission_amount . ' ' . __('store.Dinar') }}</div>
                                <div class="bttm-text">{{ (int)$order->vat_ratio . ' %' }}</div>
                                <div class="bttm-text">{{ $order->vat_amount . ' '  . __('store.Dinar') }}</div>
                                <div class="bttm-text">{{ $order->final_total . ' ' . __('store.Dinar') }}</div>
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



                @if ($order->offers->count() > 0)
                    <div class="card-top mt-4">
                        <h5 class="card-top-right font_bold">{{ __('store.Medical details') }}</h5>
                        <div class="card-top-left">
                            <div class="quentity">
                                {{ __('store.The number of items required') }} : <span>{{ count($orderGroups) . ' ' . __('store.guild') }}</span></div>
                        </div>
                    </div>

                    @foreach($orderGroups as $group)
                        @if($group->offer_id != null)
                            <div class="box-for-product mb-3 mt-4">
                                <div class="box-for-product-right">
                                    <img
                                            src="{{ optional($group->offer)->image }}"
                                            alt=""
                                    />
                                </div>
                                <div class="box-for-product-left">
                                    <div class="box-for-product-left-f-top mb-3">
                                        <h6 class="font-bold no-border-bottom padding-btm-no">
                                            {{ optional($group->offer)->name }}
                                        </h6>
                                        <div class="center-flex">

                                            <div class="line-spe-div">{{ __('store.price') . ' : ' . optional($group->offer)->offer_price . ' ' . __('store.Dinar') }}</div>
                                        </div>
                                    </div>
                                    <div class="par-code">{{ optional($group->offer)->offer_num }}</div>
                                    <div class="all-spans">
                                        <span>{{ __('store.number of products') }}:</span>
                                        <span>( {{ optional($group->offer)->products()->count() }} )</span>
                                    </div>
                                    <div class="decive-job">
                                        <span class="hegh-span"> {{ __('store.Type') }}</span>
                                        <span>( {{ __('store.offer') }} )</span>
                                    </div>
                                    <div class="decive-job">
                                        <span class="hegh-span"> {{ __('store.end_offer') }}</span>
                                        <span>( {{ Carbon\Carbon::parse(optional($group->offer)->end_offer)->translatedFormat('j F Y') }} )</span>
                                    </div>
                                </div>
                            </div>
                        @elseif(optional($group->product)->category_type == 'equipment')
                            <div class="box-for-product mb-3 mt-4">
                                <div class="box-for-product-right">
                                    <img
                                            src="{{ optional($group->product)->image }}"
                                            alt=""
                                    />
                                </div>
                                <div class="box-for-product-left">
                                    <div class="box-for-product-left-f-top mb-3">
                                        <h6 class="font-bold no-border-bottom padding-btm-no">
                                            {{ optional($group->product)->name }}
                                        </h6>
                                        <div class="center-flex">

                                            <div class="line-spe-div"><span>{{ __('store.price') }} : </span>{!! optional($group->product)->display_price_one() !!}</div>
                                        </div>
                                    </div>
                                    <div class="par-code">{{ optional($group->product)->product_num }}</div>
                                    <div class="all-spans">
                                        <span>{{ __('store.Type') }} :</span>
                                        <span>( {{ __('store.equipment') }} )</span>
                                    </div>
                                    <div class="decive-job">
                                        <span class="hegh-span"> {{ __('store.About the device') }}:</span>
                                        <p class="color-gray">
                                        {{ optional($group->product)->desc }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="box-for-product mb-3 mt-4">
                                <div class="box-for-product-right">
                                    <img
                                            src="{{ optional($group->product)->image }}"
                                            alt=""
                                    />
                                </div>
                                <div class="box-for-product-left">
                                    <div class="box-for-product-left-f-top mb-3">
                                        <h6 class="font-bold no-border-bottom padding-btm-no">
                                            {{ optional($group->product)->name }}
                                        </h6>
                                        <div class="center-flex">

                                            <div class="line-spe-div"><span>{{ __('store.price') }} : </span>{!! optional($group->product)->display_price_one() !!}</div>
                                        </div>
                                    </div>
                                    <div class="par-code">{{ optional($group->product)->product_num }}</div>
                                    <div class="all-spans">
                                        <span>{{ __('store.Type') }} :</span>
                                        <span>( {{ __('store.medicine') }} )</span>
                                    </div>
                                    <div class="all-spans">
                                        <span>{{ __('store.Active substances') }}:</span>
                                        <span>{{ optional($group->product)->effective_material }}</span>

                                    </div>
                                    <div class="decive-job">
                                        <span class="hegh-span"> {{ __('store.medicine description') }}:</span>
                                        <p class="color-gray">
                                            {{ optional($group->product)->desc }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif


{{--                @if ($order->products->count() > 0)--}}
{{--                    <div class="card-top mt-4">--}}
{{--                        <h5 class="card-top-right font_bold">@lang('localize.products')</h5>--}}
{{--                        <div class="card-top-left">--}}
{{--                            <div class="quentity">@lang('localize.available_offers_number'): <span>{{ count($order->products) }}--}}
{{--                                    @lang('localize._offer')</span></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    @foreach ($order->products as $product)--}}
{{--                        <div class="box-for-product mb-3">--}}
{{--                            <div class="box-for-product-right">--}}
{{--                                <img src="{{ $product->image }}" alt="" />--}}
{{--                            </div>--}}
{{--                            <div class="box-for-product-left">--}}
{{--                                <div class="box-for-product-left-f-top mb-3">--}}
{{--                                    <h6 class="font-bold no-border-bottom padding-btm-no">--}}
{{--                                        {{ $product->name }}--}}
{{--                                    </h6>--}}
{{--                                    <div class="center-flex">--}}
{{--                                        <div class="line-spe-div">@lang('localize.available_qty') :--}}
{{--                                            {{ optional($product->groupOne())->in_stock_qty }} @lang('localize.packet')</div>--}}
{{--                                        <div class="line-spe-div">@lang('localize.price') : {{ optional($product)->price }}--}}
{{--                                            @lang('site.currency')--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    @if (--}}
{{--                                        $notInCart = !in_array(--}}
{{--                                            $offer->id,--}}
{{--                                            provider(request()->segment(1))->cartProductOffers()->pluck('product_id')->toArray()))--}}
{{--                                        <a href="#" data-qty="1"--}}
{{--                                            data-add-cart-url="{{ route('pharmacy.cart.addProduct', $product->id) }}"--}}
{{--                                            class="color-main "><i class="fa-solid fa-cart-plus"></i>--}}
{{--                                            @lang('localize.add_to_cart')</a>--}}
{{--                                    @else--}}
{{--                                        <button class="left-device add-btn">sdf--}}
{{--                                            <i class="fa fa-check"></i>--}}
{{--                                        </button>--}}
{{--                                    @endif--}}
{{--                                </div>--}}

{{--                                <div class="decive-job">--}}
{{--                                    <span class="hegh-span"> @lang('localize.active_substances'):</span>--}}
{{--                                    <p class="color-gray">--}}
{{--                                        {{ $product->effective_material }}--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                                <div class="decive-job">--}}
{{--                                    <span class="hegh-span"> @lang('localize.medicine_desc'):</span>--}}
{{--                                    <p class="color-gray">--}}
{{--                                        {{ $product->desc }}--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                                <div class="box-for-product-left-rr">--}}
{{--                                    <div>@lang('localize.discount') {{ $offer->discount }} @lang('site.currency')</div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                @endif--}}

            </div>

            @if ($order->status == 'pending')
                <div class="flex-eend">
                    <form method="POST" class="form" action="{{ route('pharmacy.myOrders.cancel', $order->id) }}">
                        @csrf
                        <button class="refuse-btn submit-button cancel_order up">@lang('localize.cancel_the_order')</button>
                    </form>
                </div>
            @endif
    </main>
@endsection
@push('js')
    <script>
        document.querySelector('.print-order').onclick = printCertificate;

        function printCertificate() {
            print();
        }
    </script>

    @include('shared.formAjax')
@endpush
