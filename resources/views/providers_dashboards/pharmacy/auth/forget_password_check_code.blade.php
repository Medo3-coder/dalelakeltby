@extends('providers_dashboards.layouts.site.dashboard-auth')

@section('css')
    <style>
        .resendCode_button {
            background: none !important;
            border: none !important;
            color: #3333ff
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
                            <h2>@lang('localize.confirmation_code')</h2>
                            <p>@lang('localize.pe_confirmation_code')</p>
                        </div>
                        <form action="{{ route('pharmacy.postForgetPasswordCheckCode') }}" method="POST" class="form">
                            @csrf
                            <div class="img-cont-code text-center">
                                <img src="{{ asset('site/imgs/code.png') }}" alt="code" />
                            </div>
                            <input type="hidden" name="code">
                            <input type="hidden" name="phone" value="{{ request()->phone }}">
                            <input type="hidden" name="country_code" value="{{ request()->country_code }}">
                            <div class="col-12 mb-3">
                                <div class="code-container">
                                    <input type="number" name="_code" class="code" min="0" max="9"
                                        required />
                                    <input type="number" name="_code" class="code" min="0" max="9"
                                        required />
                                    <input type="number" name="_code" class="code" min="0" max="9"
                                        required />
                                    <input type="number" name="_code" class="code" min="0" max="9"
                                        required />
                                    <input type="number" name="_code" class="code" min="0" max="9"
                                        required />
                                    <input type="number" name="_code" class="code" min="0" max="9"
                                        required />
                                </div>
                            </div>
                            <div class="dont-have">
                                <div class="dont-have-text">@lang('localize.dont_receive_code')</div>
                                <button disabled class="resendCode_button"><span class="timeCounter"></span>
                                    @lang('localize.resend')</button>
                            </div>
                            <button class="submit submit-button up">@lang('localize.f_confirm')</button>
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

    <div class="modal fade" id="searchMODEL" tabindex="-1" aria-labelledby="searchMODELlLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img class="gif-img" src="{{ asset('site/imgs/7717-successful.gif') }}" alt="" />
                    <h4 class="text-center fontBold">
                        @lang('localize.password_was_reset')
                    </h4>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="myformspe" class="btn btn-primary donebtn up">
                        @lang('localize.done')
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @include('shared.formAjax')

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

        function onSubmit() {
            const code =
                console.log(code)
        }

        $('input[name="_code"]').on('change', function() {
            $('input[name="code"]').val([...document.getElementsByClassName('code')].filter(({
                    name
                }) => name)
                .map(({
                    value
                }) => value)
                .join(''))
        })
    </script>

    <script>
        let times = 1;
        let counter = 60;

        function resendCode() {
            if (counter == 0) {
                counter = 60 * times;
                $('.resendCode_button').attr('disabled', true);
                $.ajax({
                    url: "{{ route('pharmacy.forgetPasswordSendCode') }}",
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
@endsection
