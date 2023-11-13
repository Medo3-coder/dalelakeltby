@extends('providers_dashboards.layouts.site.dashboard-auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('/site') }}/flag/build/css/intlTelInput.min.css" />
    <style>
        .iti--allow-dropdown .iti__flag-container,
        .iti--separate-dial-code .iti__flag-container {
            right: 11px !important;
            width: 100px;
        }
    </style>
@endsection


@section('content')
    <section class="content">
        <section class="start">
            <div class="right-sec sec">
                <div class="content1">
                    <div class="form-co">
                        <div class="info">
                            <h2>{{ __('site.login') }}</h2>
                            <p>{{ __('site.enter_login_data') }}</p>
                        </div>

                        <form action="{{route('lab.loginEmployees')}}"  enctype="multipart/form-data" class="form"  method="POST" >
                            @csrf
                            <div class="input-g input-group-full age-date inp-cont-spe mb-3">
                                <label class="special-tele" for="">@lang('localize.phone_number')</label>
                                <input type="hidden" id="country_code" name="country_code">
                                <input type="tel" name="phone" id="telephone" placeholder="@lang('localize.please_enter_phone_number')"
                                       class="inp-spe" />
                                <div class="error_show error_country_code"> </div>
                                <div class="error_show error_phone"> </div>
                            </div>

                            <div class="input-co">
                                <label for="" class="m-t-spe">{{ __('site.password') }}</label>
                                <input type="password" name="password" id="inputpass" placeholder="{{ __('site.please_enter') }} {{ __('site.password') }}" />
                                <span class="check-ic" id="check-ic"><i class="fa-regular fa-eye"></i></span>
                                <div class="error_show error_password"> </div>
                            </div>
                            <div class="link">
                                <a href="{{route('lab.forgetPassword')}}">{{ __('site.forgetPass') }}</a>
                            </div>
                            <button class="submit up submit-button loading">{{ __('site.login') }}</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="left-sec sec">
                <div class="content2">
                    <h2 class="head">{{ __('site.welcome_back_to_app') }}</h2>
                    <p class="text">{{ __('site.please_enter_your_login_data_or_register') }}</p>
                </div>
            </div>

        </section>
    </section>
@endsection
@section('js')

    <script src="{{ asset('/site/') }}/flag/build/js/intlTelInput.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var input = document.querySelector("#telephone");
        let iti = window.intlTelInput(input, {
            autoPlaceholder: "ادخل",
            customPlaceholder: "kggg",
            initialCountry: "sa",
            // nationalMode:false,
            separateDialCode: true,
        });

        var loadFiles = function(event) {
            var images = document.getElementById("change-profile");
            images.src = URL.createObjectURL(event.target.files[0]);
        };

        $('#country_code').val(iti.getSelectedCountryData()['dialCode'])
    </script>
    @include('shared.formAjax')
@endsection