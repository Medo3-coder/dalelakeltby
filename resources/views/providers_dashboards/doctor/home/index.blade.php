@extends('providers_dashboards.layouts.dashboards.master')

@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">
                    <h6>{{ __('doctor.dashboard') }}</h6>
                    <p>{{ __('doctor.welcome_back_mr', ['name' => auth('doctor')->user()->name]) }}</p>
                </div>
                <a href="{{ route('doctor.medicine.create') }}"
                    class="test-result up add-medicine">{{ __('doctor.add_medicine') }}</a>
            </div>

            <div class="home-boxes">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">{{ $newReservationsCount }}</div>
                                <div class="home-title">{{ __('doctor.new_orders') }}</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">{{ $finishedReservationCount }}</div>
                                <div class="home-title">{{ __('doctor.previos_orders') }}</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">{{ $addedMedicinesCount }}</div>
                                <div class="home-title">{{ __('doctor.added_midecines') }}</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">{{ $finishedReservationCount }}</div>
                                <div class="home-title">{{ __('doctor.number_prescriptions') }}</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="side-heading mt-4">
                <h6>{{ __('doctor.incomming_orders') }}</h6>
                <p>{{ __('doctor.can_see_new_orders_her') }}</p>
            </div>

            <div class="overflowx_auto mb-3 table_content_append">
                {{-- tablw will append here --}}
            </div>
        </div>
        <!-- Start Trainer Section -->
        <div class="container">
            <section class="trainer">
                <div class="cards">
                    @if (count($mostUsedMedicines) > 0)
                        <div class="card right">
                            <h1 class="heading">{{ __('doctor.most_used_medicines') }}</h1>
                            <div class="courses">
                                @foreach ($mostUsedMedicines as $key => $mostUsedMedicine)
                                    <a href="{{ route('doctor.medicine.edit', $mostUsedMedicine['doctor_medican_id']) }}">
                                        <div class="course">
                                            <!-- <a href="#"></a> -->
                                            <div class="flex-course-m">
                                                <div class="num">#{{ ++$key }}</div>
                                                <div class="content">
                                                    <div class="img">
                                                        <img src="{{ $mostUsedMedicine['doctor_medicine']['image'] }}"
                                                             alt="" />
                                                    </div>
                                                    <div class="info">
                                                        <h3>{{ $mostUsedMedicine['doctor_medicine']['name'] }}</h3>
                                                        <p>
                                                            {{ $mostUsedMedicine['doctor_medicine']['type'] }}
                                                        </p>
                                                        <div class="address-spe">
                                                            {{ __('doctor.medicine_descriped', ['number' => $mostUsedMedicine['count']]) }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <i class="fa-solid fa-angle-left icon-right"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if (count($openions) > 0)
                        <div class="left card">
                            <h1 class="heading">{{ __('doctor.patients_openion') }}</h1>

                            @foreach ($openions as $openion)
                                <div class="left-flex">
                                    <img src="{{ $openion->user->image }}" alt="" />
                                    <div class="inner-left">
                                        <h6>{{ $openion->user->name }}</h6>
                                        <div class="inner-flex">
                                            <i class="fa-regular fa-clock gray-col"></i>
                                            <div class="time-left gray-col">
                                                {{ Carbon\Carbon::parse($openion->updated_at)->diffForHumans() }}</div>
                                            <div class="stars-container-spe">
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if ($i < $openion->rate)
                                                        <i class="fa-solid fa-star star-yel"></i>
                                                    @else
                                                        <i class="fa-solid fa-star star-gray"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="gray-col">
                                            {{ $openion->comment }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>


    <!-- Modal 1 -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe">
                    <h4 class="font_bold">@lang('site.refuse_order_reason')</h4>
                    <form action="{{ route('doctor.reservations.refuse') }}" method="POST" enctype="multipart/form-data"
                        class="form">
                        @csrf
                        @method('put')
                        <input type="hidden" name="reservation_id" id="reservation_id">
                        <div class="input-icon mb-3">
                            <select name="cancel_reason_id" id="" class="default_input">
                                <option disabled selected value>{{ __('admin.choose') . ' ' . __('admin.cancelreason') }}
                                </option>
                                @foreach ($cancelReasons as $reason)
                                    <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="submit" class="submit submit_button">
                                @lang('site.confirm')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 accept -->
    <div class="modal fade" id="staticBackdrop2" tabindex="-1" aria-labelledby="staticBackdrop2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="" />
                    <div class="font_bold don-t">
                        @lang('site.order_accepted_follow')
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">
                            @lang('site.done')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3 refused -->
    <div class="modal fade" id="staticBackdrop3" tabindex="-1" aria-labelledby="staticBackdrop2Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="" />
                    <div class="font_bold don-t">@lang('site.order_refused_successfully')</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">
                            @lang('site.done')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>

    @include('admin.shared.filter_js', ['index_route' => route('doctor.home')])


    <script>
        flatpickr("#myDate", {
            disableMobile: "true",
        });
    </script>

    <script>
        $(document).on('click', '.refuse_order', function() {
            $('#reservation_id').val($(this).data('reservation_id'))
        });
    </script>

    <script>
        $(document).on('click', '.accept_order', function() {
            var url = $(this).data('url')
            $.ajax({
                url: url,
                method: 'put',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: (response) => {
                    if (response.status != 'success') {
                        toastr.error(response.msg)
                    } else {
                        $('#staticBackdrop2').modal('show');
                        getData({
                            'searchArray': searchArray()
                        });
                    }
                },
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', '.form', function(e) {
                var old_content = $(".submit_button").html()
                e.preventDefault();
                var url = $(this).attr('action')
                $.ajax({
                    url: url,
                    method: 'post',
                    data: new FormData($(this)[0]),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        old_content = $(".submit_button").html()
                        $(".submit_button").html(
                            '<div class="w-100 d-flex justify-content-center text-center"><div class="submit-loader"></div></div>'
                        ).attr('disable', true);
                    },
                    success: (response) => {
                        $(".submit_button").html(old_content).attr('disable', false)
                        if (response.status != 'success') {
                            toastr.error(response.msg)
                        } else {
                            $('#staticBackdrop').modal('hide');
                            $('#staticBackdrop3').modal('show');
                            getData({
                                'searchArray': searchArray()
                            });
                        }
                    },
                    error: () => {
                        $(".submit_button").html(old_content).attr('disable', false)
                    }
                });

            });
        });
    </script>
    {{-- staticBackdrop2 --}}
@endpush
