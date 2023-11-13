@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top">

                <div class="side-heading mt-4">
                    <h6>@lang('site.comming_orders')</h6>
                    <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('lab')->user()->name])</p>
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
                        <input name="created_at_min"  type="datetime-local" id="myDate"  placeholder="@lang('site.select_date')" class="default-date-inp search-input" />
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <div class="inp-date-con  d-flex flex-row">
                        <div class="select-spe-text" style="padding: 10px">@lang('site.to')</div>
                        <input name="created_at_max"  type="datetime-local" id="myDate"  placeholder="@lang('site.select_date')" class="default-date-inp search-input" />
                        <i class="fa-regular fa-calendar"></i>
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
    <script src="{{asset('admin/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('admin.shared.filter_js' , [ 'index_route' => url('lab/accepted-reservations')])


    <script>
      flatpickr("#myDate", {
        disableMobile: "true",
      });
    </script>

    <script>
      $(document).on("click", ".follow", function () {
        if ($(this).hasClass("unfollowed")) {
          $(this).removeClass("unfollowed");
          $(this).addClass("followed");
          $(this).addClass("followed2");
          $(this).removeClass("followed3");
          $(this).html(`تم دخول المريض`);
        } else if ($(this).hasClass("followed")) {
          $(this).removeClass("followed");
          $(this).addClass("followed3");
          $(this).removeClass("followed2");
          $(this).addClass("unfollowed");

          $(this).html(`دخول المريض`);
        }
      });
    </script>
@endpush
