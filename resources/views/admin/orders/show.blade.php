@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/pages/app-user.css') }}">
@endsection
@section('content')
    <div class="content-body">
        <!-- page users view start -->
        <section class="page-users-view">
            <div class="row">

                <!-- information start -->
                <div class="col-md-6 col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">{{ awtTrans('بيانات الطلب') }}</div>
                            <span style="float: left ; margin-left:2px">{{ awtTrans('المسافة بين النقطتين ') }} <small
                                    class="distance"> </small> {{ awtTrans(' كيلو متر ') }}</span>
                        </div>
                        <div>
                            <div id="map" style="height: 400px; margin: 10px"></div>
                            <input type="hidden" id="pharmacy_lat" value="{{ optional(getUser($order)->firstBranch())->lat }}">
                            <input type="hidden" id="pharmacy_lng" value="{{ optional(getUser($order)->firstBranch())->lng }}">
                            <input type="hidden" id="store_lat" value="{{ optional($order->store->firstBranch())->lat }}">
                            <input type="hidden" id="store_lng" value="{{ optional($order->store->firstBranch())->lng }}">
                        </div>

                        <div class="card-body" style="overflow:auto;">

                            <table class="table text-center" style="width: 50%">
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


                            <table>
                                <tbody class="w-100">


                                    <tr>
                                        <td class="font-weight-bold"> {{ __('store.subtotal') }} :</td>
                                        <td>{{ !empty($order->discount) ? ($order->total_price + $order->discount) . ' ' . __('store.Dinar') : ($order->total_price) . ' ' . __('store.Dinar') }}</td>
                                    </tr>

                                    @if(!empty($order->discount))
                                        <tr>
                                            <td class="font-weight-bold"> {{ __('store.Total after discount') }} :</td>
                                            <td>{{ ($order->total_price) . ' ' . __('store.Dinar') }}</td>
                                        </tr>
                                    @endif

                                    @if($order->receiving_method == 'by_delegate')
                                    <tr>
                                        <td class="font-weight-bold"> {{ __('store.Delivery value') }} :</td>
                                        <td>{{ $order->delivery_price . ' ' . __('store.Dinar') }}</td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td class="font-weight-bold"> {{ __('store.Application commission') }} :</td>
                                        <td>{{ (int)$order->admin_commission_amount . ' ' . __('store.Dinar') }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold"> {{ __('store.Added tax rate') }} :</td>
                                        <td>{{ (int)$order->vat_ratio . ' %'  }}</td>
                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold"> {{ __('store.value added tax') }} :</td>
                                        <td>{{ $order->vat_amount . ' '  . __('store.Dinar') }}</td>
                                    </tr>

                                    <tr style="border-bottom: 2px solid black">
                                        <td class="font-weight-bold"> {{ __('store.total order') }} : </td>
                                        <td>{{ $order->final_total . ' ' . __('store.Dinar') }}</td>
                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.order_details') }} </td>

                                        <td colspan="3">{{ $order->notes }}</td>


                                    </tr>



                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.Receiving_method') }} </td>

                                        <td class="font-weight-bold">{{ __('store.' . $order->receiving_method) }} </td>
                                    </tr>



                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.deliver_date') }} </td>
                                      
                                        <td colspan="3">{{ $order->deliver_date != null ? $order->deliver_date : __('admin.Not selected yet') }}</td>

                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.prepare_time') }} </td>
                                        {{-- {{\Carbon\Carbon::createFromFormat('H:i:s',$time)->format('h:i')}} --}}
                                        <td>{{ $order->prepare_time  != null ? $order->prepare_time : __('admin.Not selected yet') }}</td>
                                    </tr>
                                    <tr>

                                        <td class="font-weight-bold">{{ __('admin.paymant_type') }} </td>
                                        @if ($order->payment_type == 'installment')
                                            <td>{{ __('admin.installment') }}</td>
                                        @elseif($order->payment_type == 'cash')
                                            <td>{{ __('admin.cash') }}</td>
                                        @elseif($order->payment_type == 'online')
                                            <td>{{ __('admin.online') }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.order_status') }} </td>
                                        @if ($order->status == 'pending')
                                            <td class="d-flex align-items-baseline">
                                                {{ __('admin.order_pending') }}
                                            </td>
                                        @elseif ($order->status == 'prepared')
                                            <td class="d-flex align-items-baseline">
                                                {{ __('admin.order_prepared') }}
                                            </td>
                                        @elseif ($order->status == 'accepted')
                                            <td class="d-flex align-items-baseline">
                                                {{ __('admin.order_approve') }}
                                            </td>
                                        @else
                                            <td class="d-flex align-items-baseline">
                                                {{ __('admin.order_rejected') }}
                                            </td>
                                        @endif


                                    </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.payment_status') }} </td>
                                    @if ($order->payment_status == 'paid')
                                        <td>{{ __('admin.paid') }}</td>
                                    @elseif($order->payment_status == 'pending')
                                        <td>{{ __('admin.not_Paid') }}</td>
                                    @endif
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- information start -->
                <div class="col-md-6 col-12 ">
                    {{-- pharamcy info  --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">{{ getTypeUser($order) == 'lab' ? __('store.lap data') : __('store.Pharmacy data') }}</div>
                            <img src="{{ optional($order)->image }}" style="width: 50px ; height: 50px;">
                        </div>

                        <div class="card-body">
                            <table>

                                <tr>
                                    <td class="font-weight-bold">{{ __('store.' . getTypeUser($order) . '.name') }} </td>
                                    <td>{{ optional(getUser($order))->name }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('store.' . getTypeUser($order) . '.branchName') }} </td>
                                    <td>{{ optional(getBranch($order))->name }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('store.' . getTypeUser($order) . '.address') }} </td>
                                    <td>{{ $order->address}}</td>
                                </tr>


                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.phone') }} </td>
                                    <td>{{ optional(getUser($order))->fullPhone }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.email') }} </td>
                                    <td>{{ optional(getUser($order))->email  }}</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    {{-- stores info --}}

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">{{ __('admin.store_info') }}</div>
                            <img src="{{ optional($order->store)->image }}" style="width: 50px ; height: 50px;">
                        </div>

                        <div class="card-body">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.name') }} </td>

                                    <td>{{ optional($order->store->firstBranch())->name }}</td>
                                </tr>


                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.phone') }} </td>

                                    <td>{{ optional($order->store)->phone }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.email') }} </td>

                                    <td>{{ optional($order->store)->email }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.order_status') }} </td>
                                    @if ($order->status == 'pending')
                                        <td class="d-flex align-items-baseline">
                                            {{ __('admin.order_pending') }}
                                        </td>
                                    @elseif ($order->status == 'prepared')
                                        <td class="d-flex align-items-baseline">
                                            {{ __('admin.order_prepared') }}
                                        </td>
                                    @elseif ($order->status == 'accepted')
                                        <td class="d-flex align-items-baseline">
                                            {{ __('admin.order_approve') }}
                                        </td>
                                    @else
                                        <td class="d-flex align-items-baseline">
                                            {{ __('admin.order_rejected') }}
                                        </td>
                                    @endif
                                </tr>

                            </table>
                        </div>
                    </div>


                    @foreach($orderGroups as $group)
                        @if($group->offer_id != null)
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0"></div>
                                    <img src="{{ optional($group->offer)->image }}" style="width: 100px ; height: 100px;">
                                </div>

                                <div class="card-body">
                                    <table>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.offer_name') }} </td>

                                            <td>{{ optional($group->offer)->name }}</td>
                                        </tr>


                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.offer code') }} </td>

                                            <td>{{ optional($group->offer)->offer_num }}</td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">{{ __('admin.number of products') }} </td>

                                            <td>{{ optional($group->offer)->products()->count() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.Type') }} </td>

                                            <td>{{ __('store.offer') }}</td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.end_offer') }} </td>

                                            <td>( {{ Carbon\Carbon::parse(optional($group->offer)->end_offer)->translatedFormat('j F Y') }} )</td>
                                        </tr>


                                    </table>
                                </div>
                            </div>
                        @elseif(optional($group->product)->category_type == 'equipment')
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0"><span>{{ __('store.price') }} : </span>{!! optional($group->product)->display_price_one() !!}</div>
                                    <img src="{{ optional($group->product)->image }}" style="width: 100px ; height: 100px;">
                                </div>

                                <div class="card-body">
                                    <table>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.product_name') }} </td>

                                            <td>{{ optional($group->product)->name }}</td>
                                        </tr>


                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.product code') }} </td>

                                            <td>{{ optional($group->product)->product_num }}</td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.Type') }} </td>

                                            <td>{{ __('store.equipment') }}</td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.About the device') }} </td>

                                            <td>{{ optional($group->product)->desc }}</td>
                                        </tr>


                                    </table>
                                </div>
                            </div>

                        @else
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title mb-0"><span>{{ __('store.price') }} : </span>{!! optional($group->product)->display_price_one() !!}</div>
                                    <img src="{{ optional($group->product)->image }}" style="width: 100px ; height: 100px;">
                                </div>

                                <div class="card-body">
                                    <table>
                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.product_name') }} </td>

                                            <td>{{ optional($group->product)->name }}</td>
                                        </tr>


                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.product code') }} </td>

                                            <td>{{ optional($group->product)->product_num }}</td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.Type') }} </td>

                                            <td>{{ __('store.medicine') }}</td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.Active substances') }} </td>

                                            <td>{{ optional($group->product)->effective_material }}</td>
                                        </tr>

                                        <tr>
                                            <td class="font-weight-bold">{{ __('store.medicine description') }} </td>

                                            <td>{{ optional($group->product)->desc }}</td>
                                        </tr>


                                    </table>
                                </div>
                            </div>

                        @endif

                    @endforeach

                    {{-- pharmacy Branch info --}}
                    {{-- <div class="card"> --}}
                    {{-- <div class="card-body">
                            <div class="col-lg-12 col-12">
                                <div class="card" style="">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('admin.comments') }}</h4>
                                    </div>
                                    <form  method="POST" action="{{route('admin.reservations.update' , ['id' => $order->id])}}" class="store form-horizontal" novalidate>
                                        @csrf
                                        @method('PUT')
                                        @if ($order->comment != null || $order->rate != null)
                                            
                                     
                                    <div class="card-content">
                                        <div class="card-body">
                                            <ul class="activity-timeline timeline-left list-unstyled">
                                                <li>
                                                    <div class="timeline-icon bg-primary">
                                                        <i class="feather icon-plus font-medium-2 align-middle"></i>
                                                    </div>
                                                    <div class="timeline-info">
                                                        <p class="font-weight-bold mb-0">{{ __('admin.name') }} :{{ $order->user->name }}</p>
                                                        <span class="font-weight-bold mb-0"> {{ __('admin.comment') }} : {{ $order->comment }}</span>
                                                    </div>

                                                    <div class="timeline-info">
                                                        <span class="font-weight-bold mb-0">{{ __('admin.rate') }}  : {{ $order->rate }}</span>
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($order->created_at)->diffForhumans() }}
                                                    </small>
                                                </li>

                                            </ul>
                                            <button type="submit" class="btn store feather icon-trash  text-danger submit_button"></button>

                                        </div>
                                    </div>
                                    @else

                                    <div class="timeline-info">
                                        <p class="font-weight-bold mb-0">{{__('admin.no_comment')}}</p>
                                    </div>
                                    @endif
                                </form>
                                </div>
                            </div>
                        </div> --}}
                    {{-- </div> --}}


                </div>

                <!-- information start -->
            </div>
        </section>
        <!-- page users view end -->

    </div>
    <!-- END: Content-->
@endsection

@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
    @include('admin.shared.submitEditForm')
    <script>
        $('.show input').attr('disabled', true)
        $('.show textarea').attr('disabled', true)
        $('.show select').attr('disabled', true)
    </script>

    <script>
        function initMap() {

            var pharmacy_lat = Number($('#pharmacy_lat').val()),
                pharmacy_lng = Number($('#pharmacy_lng').val()),
                store_lat = Number($('#store_lat').val()),
                store_lng = Number($('#store_lng').val())


            const directionsRenderer = new google.maps.DirectionsRenderer({
                map: new google.maps.Map(document.getElementById("map"), {}),
                // directions: result,
                routeIndex: 0,
                polylineOptions: {
                    strokeColor: "red"
                }
            });

            calculateAndDisplayRoute(new google.maps.DirectionsService(), directionsRenderer, pharmacy_lat, pharmacy_lng,
                store_lat, store_lng);

            $('.distance').html(haversine_distance(pharmacy_lat, pharmacy_lng, store_lat, store_lng))
        }

        function calculateAndDisplayRoute(directionsService, directionsRenderer, lat1, lng1, lat2, lng2) {
            directionsService.route({
                origin: {
                    lat: lat1,
                    lng: lng1
                },
                destination: {
                    lat: lat2,
                    lng: lng2
                },
                travelMode: google.maps.TravelMode['DRIVING'],
            }).then((response) => {
                directionsRenderer.setDirections(response);
            }).catch((e) => window.alert("Directions request failed due to " + status));
        }

        function haversine_distance(lat1, lng1, lat2, lng2) {
            var R = 3958.8; // Radius of the Earth in miles
            var rlat1 = lat1 * (Math.PI / 180); // Convert degrees to radians
            var rlat2 = lat2 * (Math.PI / 180); // Convert degrees to radians
            var difflat = rlat2 - rlat1; // Radian difference (latitudes)
            var difflon = (lng2 - lng1) * (Math.PI / 180); // Radian difference (longitudes)

            var d = 2 * R * Math.asin(Math.sqrt(Math.sin(difflat / 2) * Math.sin(difflat / 2) + Math.cos(rlat1) * Math.cos(
                rlat2) * Math.sin(difflon / 2) * Math.sin(difflon / 2)));
            return Math.round(d, 5);
        }
    </script>


    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ $settings['google_places'] }}&callback=initMap&language={{ lang() }}"
        type="text/javascript"></script>
@endsection
