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
                    <h6>@lang('localize.prepared_orders')</h6>
                    <p>@lang('localize.you_can_trace_orders_from_here')</p>
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

    @include('admin.shared.filter_js', ['index_route' => route('pharmacy.myOrders.prepared')])


    <script>
        flatpickr("#myDate", {
            disableMobile: "true",
        });
    </script>

@endpush
