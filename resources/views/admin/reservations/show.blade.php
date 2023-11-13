@extends('admin.layout.master')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">

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
                            <div class="card-title mb-0">{{ awtTrans('بيانات الحجز') }}</div>
                            <span style="float: left ; margin-left:2px">{{ awtTrans('المسافة بين النقطتين ') }} <small
                                    class="distance"> </small> {{ awtTrans(' كيلو متر ') }}</span>
                        </div>
                        <div>
                            <div id="map" style="height: 400px; margin: 10px"></div>
                            <input type="hidden" id="clinic_lat" value="{{ $reservation->clinic?->lat }}">
                            <input type="hidden" id="clinic_lng" value="{{ $reservation->clinic?->lng }}">
                            <input type="hidden" id="user_lat" value="{{ $reservation->user?->lat }}">
                            <input type="hidden" id="user_lng" value="{{ $reservation->user?->lng }}">
                        </div>

                        <div class="card-body" style="overflow:auto;">
                            <table>
                                <tbody class="w-100">
                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.Reservation price') }} :</td>
                                        <td>{{ $reservation->reservation_price . ' ' . __('store.Dinar') }}</td>

                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.Disclosure price') }} :</td>
                                        <td>{{ $reservation->detection_price . ' ' . __('store.Dinar') }}</td>

                                    </tr>

                                    @if($reservation->analysis_price != null)
                                        <tr>
                                            <td class="font-weight-bold">{{ __('admin.Analysis price') }} :</td>
                                            <td>{{ $reservation->analysis_price . ' ' . __('store.Dinar') }}</td>

                                        </tr>
                                    @endif


                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.Application commission rate') }} :</td>
                                        <td>{{ $reservation->admin_commission_ratio . ' %' }}</td>

                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.Application commission value') }} :</td>
                                        <td>{{ $reservation->admin_commission_amount . ' ' . __('store.Dinar') }}</td>

                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.Added tax rate') }} :</td>
                                        <td>{{ $reservation->vat_rate_ratio . ' %' }}</td>

                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.value added tax') }} :</td>
                                        <td>{{ $reservation->vat_rate_amount . ' ' . __('store.Dinar') }}</td>

                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.Total Reservation') }} :</td>
                                        <td>{{ $reservation->final_total . ' ' . __('store.Dinar') }}</td>

                                    </tr>


                                    <tr>
                                        <td class="font-weight-bold">{{ awtTrans('طريقة الدفع ')  }} </td>

                                        <td colspan="3">{{ __('admin.reservation_' . $reservation->payment_method) }}</td>


                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.reservation_status') }} </td>

                                        <td colspan="3">{{ __('admin.tr_reservation_' . $reservation->status) }}</td>


                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">{{ awtTrans('حالة الدفع') }} </td>

                                        <td colspan="3">{{ __('admin.reservation_' . $reservation->payment_status) }}</td>


                                    </tr>

                                    <tr>
                                        <td class="font-weight-bold">{{ awtTrans('تفاصيل الحجز') }} </td>

                                        <td colspan="3">{{ $reservation->details }}</td>


                                    </tr>


                                    <tr>
                                    </tr>
                                 

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- information start -->
                <div class="col-md-6 col-12 ">
                    {{-- store info  --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">{{ __('admin.doctor_details') }}</div>
                            <img src="{{ $reservation->clinic?->doctor->image }}" style="width: 50px ; height: 50px;">
                        </div>

                        <div class="card-body">
                            <table>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.name') }} </td>
                                    <td>{{ $reservation->clinic?->doctor->name }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.Specialty') }} </td>
                                    <td>{{ $reservation->clinic?->doctor->category->name }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.category') }} </td>
                                    <td>{{ $reservation->clinic?->doctor->category->name }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.phone') }} </td>
                                    <td>{{ $reservation->clinic?->doctor->phone }}</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    {{-- user info --}}
                    @if ($reservation->same_person)
                        
             
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">{{ __('admin.patient_details') }}</div>

                            <img src="{{ $reservation->user?->image }}" style="width: 50px ; height: 50px;">

                        </div>

                        <div class="card-body">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_name') }} </td>

                                    <td>{{ $reservation->user?->name }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_height') }} </td>

                                    <td>{{ $reservation->user?->height }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_weight') }} </td>

                                    <td>{{ $reservation->user?->weight }}</td>
                                </tr>


                                <tr>
                                    <td class="font-weight-bold">{{ awtTrans('سن المريض') }} </td>

                                    <td>{{ $reservation->user?->age }}</td>
                                </tr>

                                <tr>

                                    <td class="font-weight-bold">{{ __('admin.reservation_status') }} </td>
                                    <td class="d-flex align-items-baseline">
                                        {{ __('admin.tr_reservation_' . $reservation->status) }}
                                    </td>

                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ awtTrans('رقم هاتف المريض') }} </td>
                                    <td>{{ $reservation->user?->phone }}</td>
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

                                    <td>{{ $reservation->paient_name }}</td>
                                </tr>

                                
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_weight') }} </td>

                                    <td>{{ $reservation->paient_weight . ' ' . __('admin.km') }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.paient_height') }} </td>

                                    <td>{{ $reservation->paient_height . ' ' . __('admin.cm') }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">{{ awtTrans('السن') }} </td>
                                    <td>{{ $reservation->paient_age . ' ' . __('admin.paient_age') }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.reservation_status') }} </td>
                                    <td class="d-flex align-items-baseline">
                                        {{ __('admin.tr_reservation_' . $reservation->status) }}
                                    </td>
                                </tr>



                            </table>
                        </div>
                    </div>
                    @endif
                    {{-- clinic info --}}
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">{{ __('admin.clinic_details') }}</div>
                        </div>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.clinic_Address') }} </td>
                                    <td>{{ $reservation->clinic?->address }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.detection_price') }} </td>
                                    <td>{{ $reservation->clinic?->detection_price . ' ' . __('store.Dinar') }}</td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold">{{ __('admin.clinic_record_number') }} </td>
                                    <td>{{ $reservation->clinic?->comerical_record }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($reservation->status == 'rejected')
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title mb-0">{{ awtTrans('اسباب الالغاء') }}</div>
                            </div>

                            <div class="card-body">
                                <table>

                                    <tr>
                                        <td class="font-weight-bold">{{ __('admin.reason') }} </td>
                                        <td>{{$reservation->close_reason }}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-12 col-12">
                                <div class="card" style="">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('admin.comments') }}</h4>
                                    </div>
                                    <form  method="POST" action="{{route('admin.reservations.update' , ['id' => $reservation->id])}}" class="store form-horizontal" novalidate>
                                        @csrf
                                        @method('PUT')
                                        @if ( $reservation->comment != NULL || $reservation->rate != NULL)
                                            
                                     
                                    <div class="card-content">
                                        <div class="card-body">
                                            <ul class="activity-timeline timeline-left list-unstyled">
                                                <li>
                                                    <div class="timeline-icon bg-primary">
                                                        <i class="feather icon-plus font-medium-2 align-middle"></i>
                                                    </div>
                                                    <div class="timeline-info">
                                                        <p class="font-weight-bold mb-0">{{ __('admin.name') }} :{{ $reservation->user?->name }}</p>
                                                        <span class="font-weight-bold mb-0"> {{ __('admin.comment') }} : {{ $reservation->comment }}</span>
                                                    </div>

                                                    <div class="timeline-info">
                                                        <span class="font-weight-bold mb-0">{{ __('admin.rate') }}  : {{ $reservation->rate }}</span>
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($reservation->created_at)->diffForhumans() }}
                                                    </small>
                                                </li>

                                            </ul>
                                            <button type="submit" class="btn store feather icon-trash  text-danger submit_button"></button>

                                        </div>
                                    </div>
                                    @else

                                    <div class="timeline-info ">
                                        <p class="font-weight-bold mt-2 ml-2 text-danger">{{__('admin.no_comment')}}</p>
                                    </div>
                                    @endif
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- information start -->
            </div>
        </section>
        <!-- page users view end -->

    </div>
    <!-- END: Content-->
@endsection

@section('js')
<script src="{{asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
<script src="{{asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js')}}"></script>
@include('admin.shared.submitEditForm')
    <script>
        $('.show input').attr('disabled', true)
        $('.show textarea').attr('disabled', true)
        $('.show select').attr('disabled', true)
    </script>

    <script>
        function initMap() {

            var user_lat = Number($('#user_lat').val()),
                user_lng = Number($('#user_lng').val()),
                clinic_lat = Number($('#clinic_lat').val()),
                clinic_lng = Number($('#clinic_lng').val())


            const directionsRenderer = new google.maps.DirectionsRenderer({
                map: new google.maps.Map(document.getElementById("map"), {}),
                // directions: result,
                routeIndex: 0,
                polylineOptions: {
                    strokeColor: "red"
                }
            });

            calculateAndDisplayRoute(new google.maps.DirectionsService(), directionsRenderer, user_lat, user_lng,
                clinic_lat, clinic_lng);

            $('.distance').html(haversine_distance(user_lat, user_lng, clinic_lat, clinic_lng))
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
