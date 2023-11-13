@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/select2.css" />

@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="card-white spe-pad">
                <h5 class="font_bold mb-4">@lang('localize.send_suggestion')</h5>
                <form class="form" action="{{ route('store.suggestions.send') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{--  <div class="mb-3 main-inp-cont col-12 col-lg-8">
                        <h6 class="fontBold mainColor font14">@lang('site.name')</h6>
                        <div class="form__label mt-0">
                            <input name="name" class="default_input" type="text" placeholder="@lang('localize.pe_name')">
                            <label class="float__label" for="">@lang('localize.pe_name') </label>
                        </div>
                        <div class="error_show error_name"><span class="mt-5 text-danger"></span></div>

                    </div>  --}}
                    <div class="mb-3 main-inp-cont col-12 col-lg-8">
                        <h6 class="fontBold mainColor font14">@lang('localize.messages')</h6>
                        <div class="form__label mt-0">
                            <input name="message" class="default_input" type="text" placeholder="@lang('localize.pe_your_suggestion')">
                            <label class="float__label" for="">@lang('localize.pe_your_suggestion')</label>
                        </div>
                        <div class="error_show error_message"><span class="mt-5 text-danger"></span></div>

                    </div>
                    <button class="submit submit-button wid-60 up mt-5">@lang('localize.send')</button>
                </form>
            </div>


        </div>
    </main>


@endsection
@push('js')

    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>

    @include('providers_dashboards.store.includes.js.formAjax')


@endpush
