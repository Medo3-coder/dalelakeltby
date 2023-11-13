@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/select2.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link rel="stylesheet" href="{{ asset('/site') }}/flag/build/css/intlTelInput.min.css" />


@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">

            <div class="side-heading">
                <h6>{{ __('store.control Board') }}</h6>
                <p>@lang('site.control_panel_welcom_message', ['user_name' => $lab->name])</p>
            </div>

            <div class="card-white font-17">
                <div class="top-card-flex">
                    <h4 class="font_bold no-border-bottom font-17">{{ __('store.Personal data') }}</h4>
                    <a href="#" data-toggle="modal" data-target="#profileModal"><i class="fa-solid fa-pen-to-square"></i></a>
                </div>
                <div class="img-cont-spe">
                    <img src="{{ $lab->image }}" alt="" >

                </div>
                <div class="col-lg-8 col-12 flex-info font_bold">
                    <div>{{ __('store.name') }} : <span class="font-700">{{ $lab->name }}</span></div>
                    <div>{{ __('store.Mobile number') }} : <span class="font-700">{{ $lab->fullPhone }}</span></div>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="profile-in font_bold mt-3 mb-3">{{ __('store.email') }} : <span class="font-700">{{ $lab->email }}</span></div>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="profile-in font_bold mb-3">{{ __('store.ID Number') }} : <span class="font-700">{{ $lab->identity_id }}</span></div>
                </div>

            </div>
            <div class="card-white font-17">
                <div class="top-card-flex">
                    <h4 class="font_bold font-17">{{ __('store.permits') }}</h4>
                    <button class="add-per up" type="button" data-toggle="modal" data-target="#exampleModal">{{ __('store.permit_add') }}</button>
                </div>


                @forelse($permits as $permit)
                    <h4 class="text-center mt-3 mb-3">{{ $permit->name }}</h4>
                    <div class="flex-photos ">
                        <div class="right-ph"><img src="{{ $permit->image }}" alt=""></div>

                        <div class="left-ph">
                            <a href="{{ $permit->file }}" target="_blank">
                                <img src="{{ asset('/') }}dashboard/imgs/pdf.png" alt="">
                            </a>
                        </div>
                    </div>
                    <a href="#" onclick="deletePermit(this)" data-val="{{ $permit->id }}"><i class="fa-solid fa-trash deletePermit"></i></a>

                @empty
                    <div class="text-center">
                        <img src="{{ asset('/') }}dashboard/imgs/empty.png" class="text-center" alt="">
                        <h4 class="text-center">{{ __('store.There are no permits') }}</h4>
                    </div>

                @endforelse



            </div>
            <div class="card-white font-17">
                <div class="top-card-flex">
                    <h4 class="font_bold no-border-bottom font-17">{{ __('translation.lab_data') }}</h4>
                    <a href="#" data-toggle="modal" data-target="#exampleModal2"><i class="fa-solid fa-pen-to-square"></i></a>
                </div>
                <div class="profile-in">{{ __('translation.lab_address') }} : <span>{{ $firstBranch->address }}</span></div>
                <div class="profile-in">{{ __('translation.lab_address_map') }} : <span>{{ $firstBranch->address_map }}</span></div>
                <div class="profile-in">{{ __('translation.lab_record_number') }} : <span>{{ $firstBranch->comerical_record }}</span></div>
                <div class="flex-btm-card">
                    <div class="right-flex-btn">{{ __('store.times of work') }} :</div>
                    <div class="left-flex-btn font-14">
                        <div class="left-top-now">
                            <div class="rr-flex-spe">
                                <div class="rr-flex-spe text-secondary">{{ __('store.today') }}</div>

                            </div>
                            <div class="rr-flex-spe">
                                <div class="rr-flex-spe text-secondary text-center">{{ __('store.the hour') }}</div>
                            </div>
                        </div>
                        @forelse($firstBranch->dates()->orderBy('day', 'ASC')->get() as $date)
                            <div class="ll-flex-card">
                                <div class="day-spe">{{ __('store.' . strtolower($date->day)) }}</div>
                                <div class="day-spe">{{ __('store.from') }} {{ Carbon\Carbon::parse($date->from)->translatedFormat('g:i A') }} {{ __('store.to') }} {{ Carbon\Carbon::parse($date->to)->translatedFormat('g:i A') }}</div>
                            </div>
                        @empty
                        @endforelse

                    </div>
                </div>
                <h4 class="font_bold mt-3 mb-3">{{ __('translation.lab_images') }}</h4>
                <div class="wid-80-spe">
                    <div class="row">
                        @forelse($firstBranch->images as $image)
                            <div class="col-lg-4 col-md-6 col-12">
                                <img src="{{ $image->image }}" alt="">
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>

            <button class="delete-spe  up delete-account" onclick="deleteAccount(this)">{{ __('store.delete account') }}</button>
        </div>
    </main>


    @include('providers_dashboards.lab.profile.includes.personal-data')
    @include('providers_dashboards.lab.profile.includes.permit')
    @include('providers_dashboards.lab.profile.includes.branches')



    <!-- Modal 22222 -->


@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('/') }}dashboard/js/jquery.fancybox.min.js"></script>
    <script src="{{ asset('/site/') }}/flag/build/js/intlTelInput.min.js"></script>

    <script>
        var input = document.querySelector("#telephone");
        let iti = window.intlTelInput(input, {
            autoPlaceholder: "ادخل",
            customPlaceholder: "kggg",
            separateDialCode: true,
            // setCountry:'20'
        });

        $("#telephone").on('countrychange', function(){
            var countryDialCode = iti.getSelectedCountryData().dialCode;
            var countryCode = $('#country_code');
            countryCode.val(countryDialCode);
        });

        var countryDialCode = iti.getSelectedCountryData().dialCode;
        var countryCode = $('#country_code');
        countryCode.val(countryDialCode);

        $(document).on('change', '.main_speciality', function() {
            getSubSpecialities();
        });
    </script>
    @include('providers_dashboards.store.includes.js.map')
    @include('providers_dashboards.store.includes.js.formAjaxRegister')
    @include('providers_dashboards.lab.includes.js.profile')


@endpush
