@extends('admin.layout.master')

@section('content')
    <!-- page users view start -->
    <section class="page-users-view">
        <div class="row">

            <!-- information start -->
            <div class="col-md-6 col-12 ">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-0">{{ awtTrans('بيانات الحجز') }}</div>

                    </div>


                    <div class="card-body" style="overflow:auto;">
                        <table>
                            <tbody class="w-100">
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.Reservation price') }} :</td>
                                    <td>{{ $reportrate->reservation->reservation_price . ' ' . __('store.Dinar') }}</td>

                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.Disclosure price') }} :</td>
                                    <td>{{ $reportrate->reservation->detection_price . ' ' . __('store.Dinar') }}</td>

                                </tr>

                                @if ($reportrate->reservation->analysis_price != null)
                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.Analysis price') }} :</td>
                                        <td>{{ $reportrate->reservation->analysis_price . ' ' . __('store.Dinar') }}</td>

                                    </tr>
                                @endif


                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.Application commission rate') }} :</td>
                                    <td>{{ $reportrate->reservation->admin_commission_ratio . ' %' }}</td>

                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.Application commission value') }} :</td>
                                    <td>{{ $reportrate->reservation->admin_commission_amount . ' ' . __('store.Dinar') }}
                                    </td>

                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.Added tax rate') }} :</td>
                                    <td>{{ $reportrate->reservation->vat_rate_ratio . ' %' }}</td>

                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.value added tax') }} :</td>
                                    <td>{{ $reportrate->reservation->vat_rate_amount . ' ' . __('store.Dinar') }}</td>

                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.Total Reservation') }} :</td>
                                    <td>{{ $reportrate->reservation->final_total . ' ' . __('store.Dinar') }}</td>

                                </tr>


                                <tr>
                                    <td class="font-weight-bold">{{ awtTrans('طريقة الدفع ') }} </td>

                                    <td colspan="3">
                                        {{ __('admin.reservation_' . $reportrate->reservation->payment_method) }}</td>


                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.reservation_status') }} </td>

                                    <td colspan="3">{{ __('admin.tr_reservation_' . $reportrate->reservation->status) }}
                                    </td>


                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ awtTrans('حالة الدفع') }} </td>

                                    <td colspan="3">
                                        {{ __('admin.reservation_' . $reportrate->reservation->payment_status) }}</td>


                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ awtTrans('تفاصيل الحجز') }} </td>

                                    <td colspan="3">{{ $reportrate->reservation->details }}</td>


                                </tr>


                                <tr>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-0">{{ __('admin.reportrate') }}</div>
                    </div>
                    <div class="card-body">
                        {{$reportrate->report}}
                    </div>
                </div>
            </div>

            <!-- information start -->
            <div class="col-md-6 col-12 ">
                {{-- store info  --}}
                <div class="card">
                    <div class="card-header">
                        <div class="card-title mb-0">{{ __('admin.doctor_details') }}</div>
                        <img src="{{ $reportrate->reservation->clinic?->doctor->image }}"
                            style="width: 50px ; height: 50px;">
                    </div>

                    <div class="card-body">
                        <table>

                            <tr>
                                <td class="font-weight-bold">{{ __('admin.name') }} </td>
                                <td>{{ $reportrate->reservation->clinic?->doctor->name }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">{{ __('admin.Specialty') }} </td>
                                <td>{{ $reportrate->reservation->clinic?->doctor->category->name }}</td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('admin.category') }} </td>
                                <td>{{ $reportrate->reservation->clinic?->doctor->category->name }}</td>
                            </tr>

                            <tr>
                                <td class="font-weight-bold">{{ __('admin.phone') }} </td>
                                <td>{{ $reportrate->reservation->clinic?->doctor->phone }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
                {{-- user info --}}
                @if ($reportrate->reservation->same_person)
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">{{ __('admin.patient_details') }}</div>

                            <img src="{{ $reportrate->reservation->user?->image }}" style="width: 50px ; height: 50px;">

                        </div>

                        <div class="card-body">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_name') }} </td>

                                    <td>{{ $reportrate->reservation->user?->name }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_height') }} </td>

                                    <td>{{ $reportrate->reservation->user?->height }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_weight') }} </td>

                                    <td>{{ $reportrate->reservation->user?->weight }}</td>
                                </tr>


                                <tr>
                                    <td class="font-weight-bold">{{ awtTrans('سن المريض') }} </td>

                                    <td>{{ $reportrate->reservation->user?->age }}</td>
                                </tr>

                                <tr>

                                    <td class="font-weight-bold">{{ __('admin.reservation_status') }} </td>
                                    <td class="d-flex align-items-baseline">
                                        {{ __('admin.tr_reservation_' . $reportrate->reservation->status) }}
                                    </td>

                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ awtTrans('رقم هاتف المريض') }} </td>
                                    <td>{{ $reportrate->reservation->user?->phone }}</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">{{ __('admin.patient_details') }}</div>
                        </div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_name') }} </td>

                                    <td>{{ $reportrate->reservation->paient_name }}</td>
                                </tr>


                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_weight') }} </td>

                                    <td>{{ $reportrate->reservation->paient_weight . ' ' . __('admin.km') }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_height') }} </td>

                                    <td>{{ $reportrate->reservation->paient_height . ' ' . __('admin.cm') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ awtTrans('السن') }} </td>
                                    <td>{{ $reportrate->reservation->paient_age . ' ' . __('admin.paient_age') }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.reservation_status') }} </td>
                                    <td class="d-flex align-items-baseline">
                                        {{ __('admin.tr_reservation_' . $reportrate->reservation->status) }}
                                    </td>
                                </tr>



                            </table>
                        </div>
                    </div>
                @endif
                {{-- clinic info --}}
              




            </div>

            <!-- information start -->
        </div>
    </section>
    <!-- page users view end -->
@endsection

@section('js')
    <script>
        $('.show input').attr('disabled', true)
        $('.show textarea').attr('disabled', true)
        $('.show select').attr('disabled', true)
    </script>
@endsection
