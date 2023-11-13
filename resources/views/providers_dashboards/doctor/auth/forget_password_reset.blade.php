@extends('providers_dashboards.layouts.site.dashboard-auth')

@section('content')
    <section class="content">
        <section class="start">
            <div class="right-sec sec">
                <div class="content1">
                    <div class="form-co">
                        <div class="info">
                            <h2>@lang('localize.new_password')</h2>
                        </div>
                        <form id="myformspe" class="form" data-success="$('#searchMODEL').modal('show')" method="POST"
                            action="{{ route('doctor.postForgetPasswordReset') }}">
                            @csrf
                            <div class="input-co">
                                <label for="">@lang('localize.new_password')</label>
                                <input type="password" name="password" id="inputpass" class="inputPassSet"
                                    placeholder="@lang('localize.pe_new_password')">
                                <span class="check-ic check-setting-ic"><i class="fa-regular fa-eye"></i></span>
                                <div class="error_show error_password"> </div>
                            </div>

                            <div class="input-co">
                                <label for="">@lang('localize.confirm_new_password')</label>
                                <input type="password" name="password_confirmation" id="inputpass2" class="inputPassSet"
                                    placeholder="@lang('localize.pe_confirm_new_password')">
                                <span class="check-ic check-setting-ic"><i class="fa-regular fa-eye"></i></span>
                                <div class="error_show error_password_confirmation"> </div>
                            </div>

                            <button class="submit submit-button up">
                                @lang('admin.confirm')
                            </button>
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
    @include('shared.formAjax')

    <script>
        // PassWord Show In Setting Page
        const iconsPassSet = document.querySelectorAll(".check-setting-ic");

        if (iconsPassSet) {
            iconsPassSet.forEach((ic) => {
                ic.addEventListener("click", function() {
                    let input = ic.parentElement.querySelector(".inputPassSet");
                    showPassword(input, ic);
                });
            });
        }

        // Function To Show And Hide Password
        function showPassword(input, icon) {
            if (input.type == "password") {
                input.setAttribute("type", "text");
                icon.innerHTML = `<i class="fa-regular fa-eye-slash"></i>`;
            } else {
                input.setAttribute("type", "password");
                icon.innerHTML = `<i class="fa-regular fa-eye"></i>`;
            }

            input.focus();
        }
    </script>
@endsection
