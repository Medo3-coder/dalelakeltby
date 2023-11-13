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
                    <h6>@lang('doctor.added_accounts')</h6>
                    <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('store')->user()->name])</p>
                </div>

            </div>

            <div class="overflowx_auto mb-3 table_content_append">
                {{-- tablw will append here --}}
            </div>
        </div>
    </main>


    <!-- Modal 1 -->
    <div class="modal fade" id="searchMODEL3" tabindex="-1" aria-labelledby="searchMODEL3Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2 modal-dialog-spe4">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe">
                    <h5 class="font_bold mb-3">@lang('site.change_password')</h5>
                    <form action="{{ route('store.rules.changePassword') }}"
                        data-success="$('#searchMODEL6').modal('show');$('#searchMODEL3').modal('hide');" class="form">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3 main-inp-cont col-12">
                            <h6 class="fontBold mainColor font14">@lang('site.password')</h6>
                            <div class="form__label">
                                <input class="default_input" type="password" name="password"
                                    placeholder="@lang('admin.please_enter') @lang('site.password')" />
                                <label class="float__label" for="">@lang('admin.please_enter') @lang('site.password')</label>
                            </div>
                            <div class="error_show error_password"><span class="mt-5 text-danger"></span></div>

                        </div>
                        <div class="mb-3 main-inp-cont col-12">
                            <h6 class="fontBold mainColor font14"> @lang('admin.password_approve')</h6>
                            <div class="form__label">
                                <input class="default_input" type="password" name="password_confirmation"
                                    placeholder="@lang('admin.please_enter') @lang('admin.password_approve') " />
                                <label class="float__label" for="">@lang('admin.please_enter') @lang('admin.password_approve') </label>
                            </div>
                            <div class="error_show error_password_confirmation"><span class="mt-5 text-danger"></span></div>

                        </div>
                        <button class="submit submit-button wid-70 up mt-5">@lang('site.save')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3 -->
    <div class="modal fade" id="searchMODEL2" tabindex="-1" aria-labelledby="searchMODEL2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="">
                    <div class="font_bold don-t">@lang('doctor.account_deleted')</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">@lang('doctor.done')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal 6 -->
    <div class="modal fade" id="searchMODEL6" tabindex="-1" aria-labelledby="searchMODEL2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="">
                    <div class="font_bold don-t"> @lang('doctor.password_changed') </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">تم</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 -->
    <div class="modal fade" id="searchMODEL" tabindex="-1" aria-labelledby="searchMODELLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/lf30_editor_ma06eft0-150x150.gif') }}" alt="">
                    <div class="font_bold don-t">@lang('doctor.are_youe_sure_want_delete_account')</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit delete_account_button red-spe">@lang('doctor.yes')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('admin.shared.filter_js', ['index_route' => route('store.rules.index')]);

    @include('shared.formAjax')


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

        $(document).on('click', '.change_password', function() {
            $('#id').val($(this).data('id'));
            $('#searchMODEL3').modal('show');
        });

        let deleteUrl = null;
        $(document).on('click', '.delete_account', function() {
            deleteUrl = $(this).data('url');
            $('#searchMODEL').modal('show');
        });

        $(document).on('click', '.delete_account_button', function() {
            $.ajax({
                url: deleteUrl,
                method: 'delete',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: (response) => {
                    if (response.status != 'success') {
                        toastr.error(response.msg)
                    } else {
                        $('#searchMODEL').modal('hide');
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
