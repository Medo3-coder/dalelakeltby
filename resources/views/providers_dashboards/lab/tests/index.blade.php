@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading text-center">
                <h6>@lang('site.control_panel')</h6>
                <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('lab')->user()->name])</p>
            </div>
            <div class="flex-top_card">
                {{--  <div class="flex-top_card-r">
                    <div class="card-r-tit">@lang('localize.test_type')</div>
                    <select name="lab_category_id" id="" class="default2-select gr">
                        <option selected disabled>@lang('localize.pc_test_category')</option>
                        @foreach ($labCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}1</option>
                        @endforeach
                    </select>
                </div>  --}}
                <div class="flex-top_card-r">
                    <div class="select-spe-text">@lang('site.filter_by')</div>
                    <select name="order" class="default-select search-input">
                        <option value>{{ __('admin.choose') }}</option>
                        <option value="ASC">{{ __('admin.Progressive') }}</option>
                        <option value="DESC" selected>{{ __('admin.descending') }}</option>
                    </select>
                </div>
                <a href="{{ route('lab.medicalTests.create') }}" class="add_new_test up"><i class="fa-solid fa-plus"></i>
                    @lang('localize.add_test') </a>
            </div>

            <div class="overflowx_auto mb-3 padding-b table_content_append">
                {{-- tablw will append here --}}
            </div>

        </div>
    </main>

    <div class="modal fade" id="searchMODEL" tabindex="-1" aria-labelledby="searchMODELLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center pad-all">
                    <img src="imgs/lf30_editor_ma06eft0-150x150.gif" alt="">
                    <div class="font_bold don-t">هل انت متاكد من حذف الحساب</div>
                    <p class="text-secondary text-center">هذا النص هو مثال لنص يمكن ان يستبدل في نفس المساحة هذا النص يمكن
                        ان يستبدل</p>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit  red-behind" data-dismiss="modal" data-toggle="modal"
                            data-target="#searchMODEL2">نعم , حذف</button>
                        <button type="button" class="submit red-behind gray-bbg" data-dismiss="modal">تراجع</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="searchMODEL2" tabindex="-1" aria-labelledby="searchMODEL2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center pad-all">
                    <img src="{{asset('dashboard/imgs/7717-successful.gif')}}" alt="">
                    <div class="font_bold don-t">@lang('localize.congrat_deleted_success')</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">@lang('doctor.yes')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('admin.shared.filter_js', ['index_route' => route('lab.medicalTests.index')])

    <script>
        // Show And Hide Menu In Data Table
        function sm(el) {
            el.parentElement.querySelector('.drop-down').classList.add("show-drop-res");
            document.addEventListener("click", (e) => {
                if (e.target.tagName != "I" || e.target != el) {
                    el.parentElement.querySelector('.drop-down').classList.remove("show-drop-res");
                }
            });
        }
    </script>

    <script>
        $(document).on('click', '.delete_test', function() {
            var url = $(this).data('url')
            $.ajax({
                url: url,
                method: 'delete',
                data: {
                    _token:"{{csrf_token()}}"
                },
                dataType: 'json',
                success: (response) => {
                    if (response.status != 'success') {
                        toastr.error(response.msg)
                    } else {
                        $('#searchMODEL2').modal('show');
                        getData({
                            'searchArray': searchArray()
                        });
                    }
                },
            });
        });
    </script>
@endpush
