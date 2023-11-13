@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">

            <div class="table-top-book">

                <div class="side-heading mt-4">
                    <h6>@lang('doctor.income')</h6>
                    <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('doctor')->user()->name])</p>
                </div>

                <div class="waiting">

                    <div class="select-spe">
                        <div class="select-spe-text">@lang('doctor.filter_with_date')</div>
                        <div class="inp-date-con">
                            <input name="date" type="datetime-local" id="myDate" placeholder="@lang('site.select_date')"
                                class="default-date-inp search-input" />
                            <i class="fa-regular fa-calendar"></i>
                        </div>
                    </div>

                    <input type="hidden" name="order" value="asc" class="search-input">
                    <div class="select-spe ">
                        <div class="select-spe-text">@lang('doctor.filter_with')</div>
                        <select name="in_month" id="" class="default-select search-input gr-col">
                            <option value="" disabled selected class="gr-col">@lang('doctor.choose_month')</option>
                            <option value="1">@lang('doctor.month_with_number.1')</option>
                            <option value="2">@lang('doctor.month_with_number.2')</option>
                            <option value="3">@lang('doctor.month_with_number.3')</option>
                            <option value="4">@lang('doctor.month_with_number.4')</option>
                            <option value="5">@lang('doctor.month_with_number.5')</option>
                            <option value="6">@lang('doctor.month_with_number.6')</option>
                            <option value="7">@lang('doctor.month_with_number.7')</option>
                            <option value="8">@lang('doctor.month_with_number.8')</option>
                            <option value="9">@lang('doctor.month_with_number.9')</option>
                            <option value="10">@lang('doctor.month_with_number.10')</option>
                            <option value="11">@lang('doctor.month_with_number.11')</option>
                            <option value="12">@lang('doctor.month_with_number.12')</option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="card-white table_content_append"> </div>
    </main>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('admin.shared.filter_js', ['index_route' => route('doctor.reports.income')])

    <script>
        flatpickr("#myDate", {
            disableMobile: "true",
        });
    </script>
@endpush
