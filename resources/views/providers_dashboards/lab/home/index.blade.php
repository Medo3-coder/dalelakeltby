@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>@lang('site.control_panel')</h6>
                <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('lab')->user()->name])</p>
            </div>
            <div class="home-boxes">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ provider('lab')->reservations()->where(['status' => 'new'])->count() }}</div>
                                <div class="home-title">@lang('site.new_orders')</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ provider('lab')->reservations()->whereIn('status', ['approved', 'on_progress', 'transfer_to_lab', 'lab_send_results'])->count() }}
                                </div>
                                <div class="home-title">@lang('site.in_progress_orders')</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ provider('lab')->reservations()->where(['status' => 'finished'])->count() }}
                                </div>
                                <div class="home-title">@lang('site.finished_orders')</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">{{ provider('lab')->reservations()->count() }}</div>
                                <div class="home-title">@lang('site.total_of_orders')</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (provider('lab')->reservations()->where(['status' => 'new'])->count() > 0)
                <div class="side-heading mt-4">
                    <h6>@lang('site.comming_orders')</h6>
                    <p>@lang('site.control_panel_welcom_message', ['user_name' => provider('lab')->name])</p>
                </div>
                <div class="overflowx_auto mb-3">
                    <table class="table text-center" style="width: 100%">
                        <thead class="table-head">
                            <tr>
                                <th class="font10">@lang('site.serial_number')</th>
                                <th class="font10">@lang('site.order_num')</th>
                                <th class="font10">@lang('site.paient_name')</th>
                                <th class="font10">@lang('site.category')</th>
                                <th class="font10">@lang('site.reservation_date')</th>
                                <th class="font10"></th>
                                <th class="font10"></th>
                            </tr>
                        </thead>
                        <tbody data-class-name="table-body">
                            @foreach (provider('lab')->reservations()->where(['status' => 'new'])->get() as $key => $reservation)
                                <tr>
                                    <td class="font12">{{ $key }}</td>

                                    <td class="font12">#{{ $reservation->id }}</td>

                                    <td class="font12">
                                        <span class="fontBold">{{ $reservation->name }}</span>
                                    </td>

                                    <td class="font12">
                                        <span class="text-secondary">{{ $reservation->labCategory->name }}</span>
                                    </td>


                                    <td class="font12">
                                        <span
                                            class="d-flex justify-content-center align-items-center">{{ $reservation->date->format('d-m-Y ') . date(' H:i A', strtotime($reservation->time)) }}</span>
                                    </td>

                                    <td class="font12">
                                        <button type="button" class="refuse_order table-btn-spe danger-bg up danger-h"
                                            data-toggle="modal" data-target="#staticBackdrop"
                                            data-reservation_id="{{ $reservation->id }}">
                                            @lang('site.cancel_order')
                                        </button>
                                    </td>
                                    <td class="font12">
                                        <button type="button" class="accept_order table-btn-spe main-bg up"
                                            data-url="{{ url('lab/accept-reservation/' . $reservation->id) }}">
                                            @lang('site.accept_order')
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Start Trainer Section -->
        <div class="container mt-3">
            <section class="trainer">
                <div class="cards">
                    @if (count($latestOffers) > 0)
                        <div class="card right">
                            <h1 class="heading">@lang('localize.devices_offers')</h1>
                            <div class="courses">

                                @foreach ($latestOffers as $key => $offer)
                                    <a href="{{ route('lab.medicalDevices.offerDetails', $offer->id) }}">
                                        <div class="course">
                                            <!-- <a href="#"></a> -->
                                            <div class="flex-course-m">
                                                <div class="num"># {{++$key}}</div>
                                                <div class="content">
                                                    <div class="img">
                                                        <img src="{{ $offer->image }}" alt="" />
                                                    </div>
                                                    <div class="info">
                                                        <h3>{{ $offer->store->name }}</h3>
                                                        <p>
                                                            {{ $offer->name }}
                                                        </p>
                                                        <div class="address-spe">
                                                            {{ $offer->store->branches()->first()?->address }}
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
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe">
                    <h4 class="font_bold">@lang('site.refuse_order_reason')</h4>
                    <form action="{{ url('lab/refuse-reservation') }}" method="POST" enctype="multipart/form-data"
                        class="form">
                        @csrf
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

    <!-- Modal 2 -->
    <div class="modal fade" id="staticBackdrop2" tabindex="-1" aria-labelledby="staticBackdrop2Label"
        aria-hidden="true">
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
                method: 'get',
                data: {},
                dataType: 'json',
                success: (response) => {
                    if (response.status != 'success') {
                        toastr.error(response.msg)
                    } else {
                        $('#staticBackdrop2').modal('show');
                        setTimeout(() => {
                            window.location.reload()
                        }, 1500);
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
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                        ).attr('disable', true)
                    },
                    success: (response) => {
                        $(".submit_button").html(old_content).attr('disable', false)
                        if (response.status != 'success') {
                            toastr.error(response.msg)
                        } else {
                            $('#staticBackdrop').modal('hide');
                            $('#staticBackdrop3').modal('show');
                            setTimeout(() => {
                                window.location.reload()
                            }, 1500);
                        }
                    },
                });

            });
        });
    </script>
    {{-- staticBackdrop2 --}}
@endpush
