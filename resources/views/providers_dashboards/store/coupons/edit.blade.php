@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>{{ __('store.Edit discount coupon information', ['code'=>$coupon->code]) }}</h6>
                <div class="links-top-to">
                    <a href="{{ route('store.coupons') }}">{{ __('store.discount coupons') }}</a>  /
                    <span class="color-main">{{ __('store.Edit discount coupon information', ['code'=>$coupon->code]) }}</span>
                </div>
            </div>
            <form action="{{ route('store.coupons.update', $coupon->id) }}" id="form" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                @method('PUT')
                <div class="card-ins">
                    <div class="card-white">
                        <h4 class="font_bold mb-4 spe-border">{{ __('store.coupon information', ['code'=>$coupon->code]) }}</h4>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.discount code') }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="text"
                                        name="code"
                                        id="code"
                                        value="{{ $coupon->code }}"
                                        placeholder="{{ __('store.discount code val') }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.discount code val') }}</label
                                >

                            </div>
                            <button class="btn btn-info" id="create_code">{{ __('store.Generate a random coupon') }}</button>
                            <div class="error_show error_code"> </div>
                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.The number of times of use') }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="number"
                                        name="max_use"
                                        value="{{ $coupon->max_use }}"
                                        placeholder="{{ __('store.Please enter the number of times used') }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.Please enter the number of times used') }}</label
                                >
                            </div>
                            <div class="error_show error_max_use"> </div>
                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.discount type') }}</h6>
                            <div class="form__label">
                                <select name="type" class="default_input" id="">
                                    <option value="ratio" {{ $coupon->type == 'ratio' ? 'selected' : '' }}>{{ __('store.ratio') }}</option>
                                    <option value="number" {{ $coupon->type == 'number' ? 'selected' : '' }}>{{ __('store.number') }}</option>
                                </select>
                                <label class="float__label" for=""
                                >{{ __('store.Please select a discount type') }}</label
                                >
                            </div>
                            <div class="error_show error_type"> </div>
                        </div>


                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.discount value') }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="number"
                                        name="discount"
                                        step="0.1"
                                        value="{{ $coupon->discount }}"
                                        placeholder="{{ __('store.Please enter the discount amount') }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.Please enter the discount amount') }}</label
                                >
                            </div>
                            <div class="error_show error_discount"> </div>
                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.The largest value of the discount') }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="number"
                                        name="max_discount"
                                        step="0.1"
                                        value="{{ $coupon->max_discount }}"
                                        placeholder="{{ __('store.Please enter the largest discount value') }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.Please enter the largest discount value') }}</label
                                >
                            </div>
                            <div class="error_show error_max_discount"> </div>
                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.Expiry date') }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="date"
                                        name="expire_date"
                                        id="expire_date"
                                        value="{{ date('Y-m-d', strtotime($coupon->expire_date)) }}"
                                        placeholder="{{ __('store.Please enter expiry date') }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.Please enter expiry date') }}</label
                                >
                            </div>
                            <div class="error_show error_expire_date"> </div>
                        </div>



                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" id="submit-button" class="submit up mt-3 mr-2 text-center submit-button">{{ __('store.Save changes') }}</button>
                </div>
            </form>
        </div>


    </main>

@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/{{ lang() }}.js"></script>


    <script>
        flatpickr("#expire_date", {
            disableMobile: "true",
            "locale": "{{ lang() }}"
        });

        function makeid(length) {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            let counter = 0;
            while (counter < length) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
                counter += 1;
            }
            return result;
        }

        $('#create_code').on('click', function (){
            event.preventDefault();
            $('#code').val(makeid(5));
        })


    </script>

    @include('providers_dashboards.store.includes.js.formAjax')

@endpush
