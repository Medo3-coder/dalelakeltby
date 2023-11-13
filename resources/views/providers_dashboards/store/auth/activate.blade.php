@extends('providers_dashboards.layouts.site.dashboard-auth')

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

                        <form action="{{route('store.activate')}}" enctype="multipart/form-data" class="form"  method="POST" >
                            @csrf
                            <div class="input-co">
                                <label for="" class="m-t-spe">{{ __('site.code') }}</label>
                                <input type="number" name="code" id="inputpass" placeholder="{{ __('site.please_enter') }} {{ __('site.change_phone_code') }}" />
                                <input type="hidden" name="phone" value="{{$phone}}">
                                <input type="hidden" name="country_code" value="{{$country_code}}">
                                <div class="error_show error_code"> </div>
                            </div>
                            <button class="submit up submit-button loading ">{{ __('site.confirm') }}</button>
                        </form>
                        <div class=" col-12 mt-2 mb-2">
                            <div class="d-flex justify-content-center">
                                <button disabled class="default_link border-0  resendCode_button fontBold"> <span
                                            class="timeCounter"></span> {{ __('site.resend_code') }}</button>
                            </div>
                        </div>

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
    <script>
        $(document).ready(function() {
            let codes = document.querySelectorAll(".code");

            $(".code-container .code").first().focus();

            codes.forEach((code, idx) => {
                code.addEventListener("keydown", (e) => {
                    if (e.key >= 0 && e.key <= 9) {
                        codes[idx].value = "";
                        if ([idx + 1] < codes.length) {
                            setTimeout(() => codes[idx + 1].focus(), 10);
                        }
                    } else if (e.key === "Backspace") {
                        setTimeout(() => codes[idx - 1].focus(), 10);
                    }
                });
            });
        });
    </script>
    <script>
        let times = 1;
        let counter = 60;

        function resendCode() {
            if (counter == 0) {
                counter = 60 * times;
                $('.resendCode_button').attr('disabled', true);
                $.ajax({
                    url: "{{ route('store.reset-code') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "phone": {{ request()->phone }},
                        "country_code": {{ request()->country_code }}
                    },
                    success: function(response) {
                        console.log(response);
                        toastr.success(response.msg);
                        times++;
                    },
                });
            }
        }

        document.querySelector('.resendCode_button').onclick = resendCode;

        function decrementCounter() {
            if (counter > 0) {
                counter--;
            } else {
                $('.resendCode_button').removeAttr('disabled');
            }
            $('.timeCounter').html(`( ${counter} )`)
        }
        setInterval(decrementCounter, 1000);
    </script>


    @include('shared.formAjax')
@endsection