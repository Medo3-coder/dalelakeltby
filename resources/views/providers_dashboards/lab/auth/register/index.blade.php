@extends('providers_dashboards.layouts.site.dashboard-auth')

@section('css')
    <link rel="stylesheet" href="{{ asset('/site') }}/flag/build/css/intlTelInput.min.css" />
    <link rel="stylesheet" href="{{ asset('/site') }}/css/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

    @livewireStyles
@endsection

@section('content')
    <section class="content">
        <div class="img-landing">
            <img src="{{ asset('/site') }}/imgs/covid19-coronavirus-outbreak-healthcare-workers-pandemic-concept-cheerful-smiling-male-doctor-white-coat-inviting-take-test-clinic-pointing-fingers-do.png"
                alt="" />
        </div>
        <div class="container">
            <div class="small-sec">
                <h4 class="text-center">@lang('localize.regester_new_account')</h4>
            </div>
        </div>
        <section class="signup-step-container">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-9">
                        <div class="wizard">
                            <div class="wizard-inner">
                                <!-- <div class="connecting-line"></div> -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active step1">
                                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"
                                            aria-expanded="true">
                                            <span class="round-tab">@lang('localize.personal_data')</span>
                                        </a>
                                    </li>
                                    <li role="presentation" class="disabled tabClass">
                                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"
                                            aria-expanded="false">
                                            <img class="tab-img" src="{{ asset('/site') }}/imgs/Group 83214.png"
                                                alt="" />
                                            <span class="round-tab">@lang('localize.lab_data')</span></a>
                                    </li>
                                    <li role="presentation" class="disabled tabClass">
                                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"
                                            aria-expanded="false">
                                            <img class="tab-img" src="{{ asset('/site') }}/imgs/Group 83214.png"
                                                alt="" />
                                            <span class="round-tab">@lang('localize.available_categories')</span></a>
                                    </li>
                                    <li role="presentation" class="disabled tabClass">
                                        <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab">
                                            <img class="tab-img" src="{{ asset('/site') }}/imgs/Group 83214.png"
                                                alt="" />
                                            <span class="round-tab">@lang('localize.password')</span></a>
                                    </li>
                                </ul>
                            </div>

                            <form role="form" action="{{ route('lab.postRegister') }}" method="POST"
                                class="login-box form" enctype="multipart/form-data">
                                @csrf
                                <div class="tab-content" id="main_form">
                                    @include('providers_dashboards.lab.auth.register.includes.html.register.personal-data')
                                    @include('providers_dashboards.lab.auth.register.includes.html.register.lab-data')
                                    @include('providers_dashboards.lab.auth.register.includes.html.register.categories')
                                    @include('providers_dashboards.lab.auth.register.includes.html.register.password')
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <!-- Modal two -->
    <div class="modal fade modal-map" id="mapModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h1 class="text font-20">من فضلك قم بإدخال العنوان</h1>
                </div>
                <div class="modal-body">
                    <div id="map2" style="width: 100%; height: 400px"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="my-btn confirm-btn2 submit up" data-bs-dismiss="modal">
                        تأكيد
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3-->
    <div class="modal fade" id="searchMODEL" tabindex="-1" aria-labelledby="searchMODELlLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img class="gif-img" src="{{ asset('/site') }}/imgs/7717-successful.gif" alt="" />
                    <h4 class="text-center fontBold">
                        @lang('localize.your_request_sent_to_admin')
                    </h4>
                </div>
                <div class="progress">
                    <div class="progress-bar"></div>
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
    <script src="{{ asset('/site/') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('/site/') }}/flag/build/js/intlTelInput.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


    {{-- <script src="{{ asset('dashboard/js/location-picker.js') }}"></script> --}}
    {{-- @include('providers_dashboards.lab.auth.register.includes.js.map' ,['draggable' => true]) --}}

    <script src="{{ asset('/site/') }}/js/jquery.fancybox.min.js"></script>
{{--    @include('providers_dashboards.store.includes.js.map')--}}


    @include('providers_dashboards.lab.auth.register.includes.js.register')


    @include('providers_dashboards.lab.auth.register.includes.js.formAjaxRegister')

    @livewireScripts
@endsection
