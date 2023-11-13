@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top">

                <div class="side-heading mt-4">
                    <h6>@lang('site.comming_orders')</h6>
                    <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('doctor')->user()->name])</p>
                </div>

                <div class="select-spe">
                    <div class="select-spe-text">@lang('site.filter_by')</div>
                    <select name="order" class="default-select search-input">
                        <option value>{{ __('admin.choose') }}</option>
                        <option value="ASC">{{ __('admin.Progressive') }}</option>
                        <option value="DESC" selected>{{ __('admin.descending') }}</option>
                    </select>
                </div>

                <div class="select-spe ">
                    <div class="select-spe-text">@lang('site.filter_by_date')</div>
                    <div class="inp-date-con d-flex flex-row">
                        <div class="select-spe-text" style="padding: 10px">@lang('site.from')</div>
                        <input name="created_at_min" type="datetime-local" id="myDate" placeholder="@lang('site.select_date')"
                            class="default-date-inp search-input" />
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <div class="inp-date-con  d-flex flex-row">
                        <div class="select-spe-text" style="padding: 10px">@lang('site.to')</div>
                        <input name="created_at_max" type="datetime-local" id="myDate" placeholder="@lang('site.select_date')"
                            class="default-date-inp search-input" />
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                </div>

            </div>

            <div class="overflowx_auto mb-3 table_content_append">
                {{-- tablw will append here --}}
            </div>
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
    <div class="modal fade" id="staticBackdrop3" tabindex="-1" aria-labelledby="staticBackdrop2Label" aria-hidden="true">
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('admin.shared.filter_js', ['index_route' => route('doctor.reservations.new')])


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
@endpush
