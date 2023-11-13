@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="card-white spe-pad">
                <h5 class="font_bold mb-4">@lang('localize.send_suggestion')</h5>
                <form class="form" action="{{ route('lab.suggestions.send') }}"
                    data-success="$('#staticBackdrop2').modal('show')">
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

    <div class="modal fade" id="staticBackdrop2" tabindex="-1" aria-labelledby="staticBackdrop2Label"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="">
                    <div class="font_bold don-t">
                        @lang('localize.msg_sent_to_admin')
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">
                            @lang('localize.done')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    @include('shared.formAjax')
@endpush
