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

                <h6 class="noborder-btm">{{ __('store.installments') }}</h6>
                <div class="overflowx_auto mb-3 table1-spe table-btm">
                    <table class="table text-center" style="width: 100%">
                        <thead class="table-head">
                        <tr>
                            <th class="font10">{{ __('store.Installment date') }}</th>
                            <th class="font10">{{ __('store.duration') }}</th>
                            <th class="font10">{{ __('store.the amount') }}</th>
                            <th class="font10">{{ __('store.paying off') }}</th>
                        </tr>
                        </thead>
                        <tbody data-class-name="table-body">
                        @forelse($installments as $installment)
                            <tr>
                                <td class="font12 text-secondary">{{ Carbon\Carbon::parse($installment->date)->translatedFormat('j F Y') }}</td>

                                <td class="font12 text-secondary">{{ $installment->duration . ' ' . __('store.days') }}</td>

                                <td class="font12">
                                    <span class="fontBold text-secondary">{{ $installment->amount . ' ' . __('store.Dinar') }}</span>
                                </td>

                                <td class="font12">
                                    @if($installment->status == 'not_paid')
                                        <button
                                                type="button"
                                                data-id="{{ $installment->id }}"
                                                class="pay-tome up follow unfollowed paid"
                                        >
                                            {{ __('store.reimbursement') }}
                                        </button>
                                    @else
                                        {{ __('store.paid') }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                        @endforelse

                        </tbody>
                    </table>
                </div>
                <div class="card-spe-price">
                    {{ __('store.Remaining amount', ['num'=>$installmentsPending]) }}
                </div>
            </div>
        </div>
    </main>



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

        $('.paid').on('click', function (){
            var id = $(this).data('id');
            event.preventDefault();

            Swal.fire({
                icon: 'info',
                iconColor: '#2f71b3',
                title: '<h5 class="font_bold">'+ "{{ __('store.Do you want to pay the amount?', ['num'=>$order->order_num]) }}" +'</h5>',
                showCancelButton: true,
                cancelButtonText:'{{ __('store.cancel') }}',
                showConfirmButton: true,
                confirmButtonText: '{{ __('store.ok') }}',
            }).then((result)=>{
                if (result.isConfirmed) {

                    $(this).ajaxSubmit({
                        url: '{{ url('store/reports/order/statusPaid') }}/' + id,
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
