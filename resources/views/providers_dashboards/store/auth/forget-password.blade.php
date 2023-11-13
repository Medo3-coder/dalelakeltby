@extends('providers_dashboards.layouts.site.dashboard-auth')

@section('content')
    <section class="content">
        <section class="start">
            <div class="right-sec sec">
                <div class="content1">
                    <div class="form-co">
                        <div class="info">
                            <h2>تسجيل دخول</h2>
                            <p>برجاء ادخال بيانات حسابك حتى تتمكن الدخول</p>
                        </div>
                        <form action="{{ route('store.forgetPassword') }}" method="POST" class="form">
                            @csrf
                            <div class="input-g input-group-full age-date inp-cont-spe mb-3">
                                <label class="special-tele" for="">@lang('localize.phone_number')</label>
                                <input type="hidden" id="country_code" name="country_code">
                                <input type="tel" name="phone" id="telephone" placeholder="@lang('localize.please_enter_phone_number')"
                                       class="inp-spe" />
                                <div class="error_show error_country_code"> </div>
                                <div class="error_show error_phone"> </div>
                            </div>
                            <button type="submit" class="submit up submit-button"> ارسال الكود</button>
                        </form>
                        <div class="dont-have">
                            <div class="dont-have-text">ليس لديك حساب؟</div>
                            <a href="{{ route('store.register') }}">اضغط هنا</a>
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

    @include('shared.formAjax')
@endsection