@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <style>
        .right-sec .form-co .info p {
            color: #8a8a8a;
            font-size: 16px;
        }

        .right-sec .form-co form .input-co {
            margin-bottom: 30px;
            position: relative;
        }

        .right-sec .form-co form .input-co label {
            display: block;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .right-sec .form-co form .input-co input {
            padding: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            outline: none;
            font-size: 14px;
        }

        .right-sec .form-co form .input-co input::placeholder {
            font-size: 12px;
            color: #bfbfbf;
        }

        .right-sec form .input-co .check-ic {
            position: absolute;
            top: 50px;
            left: 10px;
        }

        .right-sec form .input-co .check-ic i {
            color: #8d8d8d;
            cursor: pointer;
        }

        .right-sec form .link {
            text-align: left;
        }

        .right-sec form .link a {
            color: var(--dark-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .right-sec form .link a:hover {
            color: var(--main-color);
        }

        .right-sec form .submit {
            border-radius: 5px;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .country_code {
            position: absolute;
            width: 127px;
            padding: 16px;
            border: 0;
        }

        .right-sec .form-co form .input-co input {
            padding: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            font-size: 14px;
        }

        input:focus,
        :not(:placeholder-shown) {
            outline-color: var(--main) !important;
        }

        .inp-spe {
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
        }

        .inp-spe {
            padding-right: 117px !important;
            padding-left: 10px !important;
            padding: 16px;
        }

        .flex-check-card label {
            width: auto !important;
            padding-left: 10px;
            padding-right: 10px
        }
    </style>
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading mt-4">
                <h6>@lang('doctor.add_rules')</h6>
                <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('pharmacy')->user()->name])</p>
            </div>
            <div class="card-white right-sec sec">
                <h4 class="font_bold col-12 ">@lang('doctor.account_details')</h4>
                <div class="form-co">
                    <form action="{{ route('pharmacy.rules.store') }}" method="POST"
                        data-success="$('#staticBackdrop').modal('show');" class="form">
                        @csrf
                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">@lang('admin.user_name')</h6>
                            <div class="form__label">
                                <input name="name" class="default_input" type="text"
                                    placeholder="@lang('admin.please_enter') @lang('admin.user_name')" />
                                <label class="float__label" for="">@lang('admin.please_enter') @lang('admin.user_name')</label>
                            </div>
                            <div class="error_show error_name"><span class="mt-5 text-danger"></span></div>
                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">@lang('localize.role_name')</h6>
                            <div class="form__label">
                                <input name="role_name" class="default_input" type="text"
                                    placeholder="@lang('admin.please_enter') @lang('localize.role_name')" />
                                <label class="float__label" for="">@lang('admin.please_enter') @lang('localize.role_name')</label>
                            </div>
                            <div class="error_show error_role_name"><span class="mt-5 text-danger"></span></div>
                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <div class="input-g input-group-full age-date input-co">
                                <label for="">{{ __('site.phone') }}</label>
                                <select class="country_code" name="country_code">
                                    <option selected disabled>{{ __('admin.select') . ' ' . __('admin.country_code') }}
                                    </option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->key }}">{{ $country->key }}</option>
                                    @endforeach
                                </select>
                                <input type="number" name="phone"
                                    placeholder="{{ __('site.please_enter') }} {{ __('site.phone') }}" class="inp-spe" />
                                <div class="error_show error_country_code"> </div>
                                <div class="error_show error_phone"> </div>
                            </div>
                        </div>



                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">@lang('admin.password')</h6>
                            <div class="form__label">
                                <input name="password" class="default_input" type="password"
                                    placeholder="@lang('admin.please_enter') @lang('admin.password')" />
                                <label class="float__label" for="">@lang('admin.please_enter') @lang('admin.password')</label>
                            </div>
                            <div class="error_show error_password"><span class="mt-5 text-danger"></span></div>
                        </div>
                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">@lang('admin.password_approve')</h6>
                            <div class="form__label">
                                <input name="password_confirmation" class="default_input" type="password"
                                    placeholder="@lang('admin.please_enter') @lang('admin.password_approve')" />
                                <label class="float__label" for="">@lang('admin.please_enter') @lang('admin.password_approve')</label>
                            </div>
                            <div class="error_show error_password_confirmation"><span class="mt-5 text-danger"></span></div>

                        </div>
                        <div class="mb-3 main-inp-cont col-12 ">
                            <h6 class="fontBold mainColor font14">@lang('doctor.user_permissions')</h6>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-5 mx-3">
                                        <div class="flex-check-card">
                                            <input type="checkbox" value="{{ $permission }}" name="permissions[]"
                                                id="accept-ref{{ $permission }}">
                                            <label
                                                for="accept-ref{{ $permission }}">{{ __('all_permissions.' . implode('', explode('.', $permission))) }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="error_show error_rules_ids"><span class="mt-5 text-danger"></span></div>
                        <div class="error_show error_permissions"> </div>

                        <button class="submit submit-button wid-70 up mt-5">@lang('doctor.create_account')</button>
                    </form>
                </div>
            </div>
    </main>

    <!-- Modal 2 -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="">
                    <div class="font_bold don-t">@lang('apis.added') </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">@lang('doctor.done')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('shared.formAjax')
@endpush
