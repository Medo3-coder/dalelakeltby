@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">

            <div class="table-top-book">
                <div class="side-heading">
                    <h6>@lang('site.comming_orders')</h6>
                    <p>@lang('localize.you_can_show_popular_stores')</p>
                </div>
                <div class="left-phar-check gray-main">
                    <div class="left-phar-check-right">
                        <label for="first-check">@lang('localize.popular_stores')</label>
                        <input class="search-input" type="checkbox" id="first-check" value="1" name="popular_stores">
                    </div>
                    <div class="left-phar-check-right">
                        <label for="Second-check">@lang('localize.nearst_stores')</label>
                        <input class="search-input" type="checkbox" id="Second-check" value="1" name="nearst_stores">
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

    @include('admin.shared.filter_js', ['index_route' => route('pharmacy.stores.index')])


    <script>
        flatpickr("#myDate", {
            disableMobile: "true",
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".count").prop("disabled", true);
            $(document).on("click", ".plus", function() {
                var count = $(this).closest(".qty").find(".count");
                $(count).val(parseInt($(count).val()) + 1);
            });
            $(document).on("click", ".minus", function() {
                var count = $(this).closest(".qty").find(".count");
                $(count).val(parseInt($(count).val()) - 1);
                if ($(count).val() == 0) {
                    $(count).val(1);
                }
            });
        });
    </script>
@endpush
