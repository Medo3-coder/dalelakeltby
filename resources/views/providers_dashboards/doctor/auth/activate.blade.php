@extends('providers_dashboards.layouts.site.dashboard-auth')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
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

                        <form action="{{ route('doctor.postActivate') }}" enctype="multipart/form-data" class="form"
                            method="POST">
                            @csrf
                            <div class="input-co">
                                <label for="" class="m-t-spe">{{ __('site.code') }}</label>
                                <input type="number" name="code" id="inputpass"
                                    placeholder="{{ __('site.please_enter') }} {{ __('site.change_phone_code') }}" />
                                <input type="hidden" name="phone" value="{{ request()->phone }}">
                                <input type="hidden" name="country_code" value="{{ request()->country_code }}">
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

    <div class="modal fade" id="searchMODEL" tabindex="-1" aria-labelledby="searchMODELlLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img class="gif-img" src="{{ asset('/site') }}/imgs/7717-successful.gif" alt="" />
                    <h4 class="text-center fontBold succ_msg">
                        @lang('localize.your_request_sent_to_admin')
                    </h4>
                </div>
                <div id="uploadStatus"></div>
                <div class="modal-footer">
                    <button type="submit" form="myformspe" class="btn btn-primary donebtn up" data-dismiss="modal">
                        @lang('localize.done')
                    </button>
                </div>
            </div>
        </div>
    </div>

    
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
                    url: "{{ route('doctor.resendCode') }}",
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


<script>
    $(document).ready(function() {
        $(document).on('submit', '.form', function(e) {
            var old_content = $(this).find(".submit-button").html()
            e.preventDefault();
            var url = $(this).attr('action')
            $.ajax({
                url: url,
                method: 'post',
                data: new FormData($(this)[0]),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: () => {
                    old_content = $(this).find(".submit-button").html()
                    $(this).find(".submit-button").html( '<div class="w-100 d-flex justify-content-center text-center"><div class="submit-loader"></div></div>').attr('disabled', true)
                },
                success: (response) => {
                    $(".error_show").html('')
                    $('.form input , .form select , .form textarea').removeClass('border-danger')
                    $(this).find(".submit-button").html(old_content).attr('disabled', false)
                    if (response.status != 'success') {
                        if (response.hasOwnProperty('input')) {
                            $('.form .error_' + response.input).append(
                                `<span class="mt-5 text-danger">${response.msg}</span>`);
                            $('.form input[name^=' + response.input + ']' +
                                    '.form select[name^=' + response.input + ']' +
                                    '.form textarea[name^=' + response.input + ']')
                                .addClass('border-danger')
                        } else {
                            toastr.error(response.msg)
                        }
                    } else {
                        $('.succ_msg').html(response.msg)
                        $('#searchMODEL').modal('show');
                    }

                    if (response.hasOwnProperty('url')) {
                        setTimeout(function() {
                            window.location.replace(response.url)
                        }, 1000);
                    }
                },
                error: (xhr) => {
                    $(".error_show").html('')
                    $('.form input , .form select , .form textarea').removeClass(
                        'border-danger')
                    $(this).find(".submit-button").html(old_content).attr('disabled', false)

                    $.each(xhr.responseJSON.errors, function(key, value) {
                        if ($('.form .error_' + key.split('.').join('\\.'))[0]) {
                            $('.form .error_' + key.split('.').join('\\.')).append(
                                `<span class="mt-5 text-danger">${value}</span>`
                            );
                            // console.log($('.form .error_' + key)[0])
                        } else {
                            if (key.indexOf(".") >= 0) {
                                var split = key.split('.')
                                key = split[0] + '\\[' + split[1] + '\\]'
                            }

                            $('.form .error_' + key).append(
                                `<span class="mt-5 text-danger">${value}</span>`
                            );
                            $('.form input[name^=' + key + ']' +
                                    '.form select[name^=' +
                                    key + ']' + '.form textarea[name^=' + key + ']')
                                .addClass('border-danger')
                        }

                    });
                },
            });

        });
    });
</script>
<script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>

@endsection
