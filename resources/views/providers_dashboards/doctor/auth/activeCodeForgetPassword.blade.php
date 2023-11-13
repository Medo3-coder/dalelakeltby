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
                            <div class="img-cont-code text-center">
                                <img src="{{ asset('/') }}site/imgs/code.png" alt="code" />
                            </div>
                            <div class="input-co">
                                <label for="" class="m-t-spe">{{ __('site.code') }}</label>
                                <input type="number" name="code" id="inputpass" placeholder="{{ __('site.please_enter') }} {{ __('site.change_phone_code') }}" />
                                <div class="error_show error_code"> </div>
                            </div>
                            <input type="hidden" name="country_code" value="{{ $store['country_code'] }}">
                            <input type="hidden" name="phone" value="{{ $store['phone'] }}">
                            <div class="dont-have">
                                <div class="dont-have-text">لم تستلم الكود؟</div>
                                <a href="" id="resetCode">اعادة ارسال</a>
                            </div>
                            <button class="submit up submit-button loading ">{{ __('site.confirm') }}</button>
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
    <script>
        $('#resetCode').on('click', function (){
            event.preventDefault();
            $.ajax({
                url: '{{ route('store.reset-code') }}',
                method: 'post',
                data: {
                    _token          :'{{ csrf_token() }}',
                    phone           :'{{ $store['phone'] }}',
                    country_code    :'{{ $store['country_code'] }}'
                },
                dataType: 'json',
                success: (response) =>  {

                    if (response.status != 'success') {
                            toastr.error(response.msg)
                    }else{
                        toastr.success(response.msg)
                    }
                },
                error: function(xhr) {

                },
            });

        });
    </script>
    @include('shared.formAjax')
@endsection