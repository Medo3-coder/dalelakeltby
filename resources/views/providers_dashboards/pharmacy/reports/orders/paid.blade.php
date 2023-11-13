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
                    <h6>@lang('localize.paid_payments')</h6>
                    <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('pharmacy')->user()->name])</p>
                </div>

                <div class="select-spe mb-1">
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

                    <div class="select-spe">
                        <div class="select-spe-text">@lang('site.filter_by')</div>
                        <select name="order" class="default-select search-input">
                            <option value>{{ __('admin.choose') }}</option>
                            <option value="ASC">{{ __('admin.Progressive') }}</option>
                            <option value="DESC" selected>{{ __('admin.descending') }}</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="overflowx_auto mb-3 table_content_append">
                {{-- tablw will append here --}}
            </div>
        </div>
    </main>
@endsection
@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('admin.shared.filter_js', ['index_route' => route('pharmacy.reports.orders.paid')])


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
