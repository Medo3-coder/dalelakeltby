@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .inner-card ,
            .inner-card *:not(.print-order) {
                visibility: visible !important;
                color: black;
            }

            #inner-card {
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
            <div class="d-flex justify-content-between align-items-center">
                <div class="side-heading">
                    <h6>{{ __('store.Order details') . ' ' . __('store.order_number', ['num'=>$order->id]) }}</h6>
                    <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('store')->user()->name])</p>
                </div>
                @if($order->status == 'accepted')
                    <div class="flex-leftrb">
                        <div class="font_bold">{{ __('store.Is it equipped?') }}</div>
                        <div class="left-sheck-me">
                            <a href="#" class="go-to-active orderPrepared">{{ __('store.ok') }}</a>
                        </div>
                    </div>
                @endif

                @if($order->status == 'prepared')
                    <div class="flex-leftrb2 font-16">
                        {{ __('store.Equipped') }}
                    </div>
                @endif




            </div>
            <div class="card-white spe-pad small-card">
                <div class="small-right">
                    <div class="felex-small">
                        <div class="right-felex">
                            <div class="circle-spe {{ in_array($order->status, ['pending', 'accepted', 'prepared']) == true ? 'activate-spe' : '' }}">1</div>
                            <div class="detail-spe font-bold">{{ __('store.under approval') }}</div>
                        </div>
                        <div class="left-felex {{ in_array($order->status, ['accepted', 'prepared']) == true ? 'activate-spe' : '' }}"></div>
                    </div>
                </div>
                <div class="small-middle">
                    <div class="felex-small">
                        <div class="right-felex">
                            <div class="circle-spe {{ in_array($order->status, ['accepted', 'prepared']) == true ? 'activate-spe' : '' }}">2</div>
                            <div class="detail-spe">{{ __('store.Accepted request') }}</div>
                        </div>
                        <div class="left-felex {{ in_array($order->status, ['prepared']) == true ? 'activate-spe' : '' }}"></div>
                    </div>
                </div>
                <div class="small-left">
                    <div class="felex-small">
                        <div class="right-felex">
                            <div class="circle-spe {{ in_array($order->status, ['prepared']) == true ? 'activate-spe' : '' }}">3</div>
                            <div class="detail-spe">{{ __('store.The request has been processed') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-white font-700 print-spe" id="printme">
                <div class="order-d-top">
                    <h6>{{ __('store.order data') }}</h6>
                    <img class="print-order" src="{{  asset('/')  }}dashboard/imgs/Group 83060.png" alt="">
                </div>
                <div class="inner-card">
                    <div class="small-t">{{ __('store.store_name') . ' : ' . $store->firstBranch()->name }}</div>
                    <div class="flex-inner-card">
                        <div class="right-inner-card">
                            <div class="inner-adress">{{ __('store.address') }} :  <span>{{ $store->firstBranch()->address }}</span></div>
                            <div class="inner-adress">{{ __('store.mobile number') }} : <span>+</span> <span>{{ $store->fullPhone }}</span> </div>
                        </div>
                        <div class="left-inner-card">
                            <div class="left-inner-card-top">
                                <div class="left-inner-card-top-r">
                                    <ul>
                                        <li>{{ __('store.invoice number') }}</li>
                                        <li>#{{ $order->order_num }}</li>
                                    </ul>
                                </div>
                                <div class="left-inner-card-top-r">
                                    <ul>
                                        <li>{{ __('store.' . $type . '.id') }}</li>
                                        <li>{{ $user->id }}</li>
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
                        </div>
                    </div>
                    <div class="check-person">{{ __('store.invoice to') }}</div>
                    <div class="row-name">{{ __('store.' . $type . '.name') }} : {{ $user->name }} </div>
                    <div class="row-name">{{ __('store.' . $type . '.branchName') }} : {{ $branch->name }}</div>
                    <div class="row-name">{{ __('store.' . $type . '.address') }} : {{ $order->address }}</div>
                    <div class="row-name">{{ __('store.mobile number') }} : {{ $user->fullPhone }}</div>
                    <div class="row-name">{{ __('store.email') }} : {{ $user->email }}</div>
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
                <div class="card-top mt-4 no-border-top">
                    <h5 class="card-top-right font_bold">{{ __('store.Medical details') }}</h5>
                    <div class="card-top-left">
                        <div class="quentity">{{ __('store.The number of items required') }} : <span>{{ count($orderGroups) . ' ' . __('store.guild') }}</span></div>
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


                @if($order->status == 'pending')
                    <div class="flex-eend2">
                        <button class="refuse-btn2 up bg-red11 rejectedOrder">{{ __('store.Rejection of the order') }}</button>
                        <button class="refuse-btn2 up" data-toggle="modal"
                                data-target="#exampleModal">{{ __('store.Acceptance of the order') }}</button>
                    </div>
                @endif


            </div>
        </div>
    </main>

    <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-spe">
            <div class="modal-content">

                <div class="modal-body no-border-bottom modal1-spe">
                    <h5 class="font-17 font_bold mb-3 ">{{ __('store.Duration of processing and delivery of the order') }}</h5>
                    <form action="{{ route('store.orders.statusAccepted') }}" method="POST" class="form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <div class="row">
                            <div class="mb-3 main-inp-cont col-12">
                                <h6 class="fontBold mainColor font14">{{ __('store.prepare_time') }}</h6>
                                <input
                                        type="text"
                                        class="apload-img-reg"
                                        placeholder="{{ __('store.prepare_time_val') }}"
                                        name="prepare_time"
                                        id=""
                                />
                                <div class="error_show error_prepare_time"> </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('store.deliver_date') }}</h6>
                                    <div class="form__label">
                                        <input
                                                type="date"
                                                class="apload-img-reg"
                                                placeholder="{{ __('store.deliver_date_val') }}"
                                                id="myDate"
                                                name="deliver_date"
                                        />

                                        <label for="myDate" class="add-photo">
                                            <i class="fa-regular fa-calendar"></i>
                                        </label>
                                    </div>
                                    <div class="error_show error_deliver_date"> </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-center">
                            <button
                                    type="submit"
                                    class="submit up mt-3 wid-80-spe submit-button"
                            >
                                {{ __('store.It was completed') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/{{ lang() }}.js"></script>
    <script>
        document.querySelector('.print-order').onclick = printCertificate;

        function printCertificate() {
            print();

        }
        flatpickr("#myDate", {
            disableMobile: "true",
            "locale": "{{ lang() }}"
        });

        $('.rejectedOrder').on('click', function (){
            event.preventDefault();

            Swal.fire({
                icon: 'info',
                iconColor: '#2f71b3',
                title: '<h5 class="font_bold">'+ "{{ __('store.Do you want to reject the order?', ['num'=>$order->order_num]) }}" +'</h5>',
                showDenyButton: true,
                showCancelButton: true,
                showConfirmButton: false,
                denyButtonText: '{{ __('store.ok') }}',
                cancelButtonText:'{{ __('store.cancel') }}'
            }).then((result)=>{
                if (result.isDenied) {

                    $(this).ajaxSubmit({
                        url: '{{ route('store.orders.statusRejected') }}',
                        method:"POST",
                        data:{
                            _token:'{{ csrf_token() }}',
                            id:'{{ $order->id }}'
                        },
                        success: (response) => {
                            if(response.status == 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    iconColor: '#2f71b3',
                                    showConfirmButton: false,
                                    title: '<h5 class="font_bold">'+ response.msg +'</h5>',

                                })
                                setTimeout(function () {
                                    window.location.reload();
                                }, 3000);
                            }else {
                                Swal.fire({
                                    icon: 'error',
                                    iconColor: '#ff0000',
                                    title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                                    showConfirmButton: true,
                                    confirmButtonText: '{{ __('store.ok') }}',

                                })
                            }

                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                iconColor: '#ff0000',
                                title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                                showConfirmButton: true,
                                confirmButtonText: '{{ __('store.ok') }}',

                            })
                        },
                    });

                }
            })
        });

        $('.orderPrepared').on('click', function (){
            event.preventDefault();
            Swal.fire({
                icon: 'info',
                iconColor: '#2f71b3',
                title: '<h5 class="font_bold">'+ "{{ __('store.Do you want to complete the order?', ['num'=>$order->order_num]) }}" +'</h5>',
                showCancelButton: true,
                cancelButtonText:'{{ __('store.cancel') }}',
                showConfirmButton: true,
                confirmButtonText: '{{ __('store.ok') }}',
            }).then((result)=>{
                if (result.isConfirmed) {

                    $(this).ajaxSubmit({
                        url: '{{ route('store.orders.statusPrepared') }}',
                        method:"POST",
                        data:{
                            _token:'{{ csrf_token() }}',
                            id:'{{ $order->id }}'
                        },
                        success: (response) => {
                            if(response.status == 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    iconColor: '#2f71b3',
                                    showConfirmButton: false,
                                    title: '<h5 class="font_bold">'+ response.msg +'</h5>',

                                })
                                setTimeout(function () {
                                    window.location.reload();
                                }, 3000);
                            }else {
                                Swal.fire({
                                    icon: 'error',
                                    iconColor: '#ff0000',
                                    title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                                    showConfirmButton: true,
                                    confirmButtonText: '{{ __('store.ok') }}',

                                })
                            }

                        },
                        error: function (xhr) {
                            Swal.fire({
                                icon: 'error',
                                iconColor: '#ff0000',
                                title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                                showConfirmButton: true,
                                confirmButtonText: '{{ __('store.ok') }}',

                            })
                        },
                    });

                }
            })
        });
    </script>

    @include('providers_dashboards.store.includes.js.formAjax')

@endpush
