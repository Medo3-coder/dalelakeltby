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
                <p>@lang('site.control_panel_welcom_message', ['user_name' => $pharmacy->name])</p>
            </div>

            <div class="card-white font-17">
                <div class="top-card-flex">
                    <h4 class="font_bold no-border-bottom font-17">{{ __('store.Personal data') }}</h4>
                    <a href="#" data-toggle="modal" data-target="#profileModal"><i class="fa-solid fa-pen-to-square"></i></a>
                </div>
                <div class="img-cont-spe">
                    <img src="{{ $pharmacy->image }}" alt="" >

                </div>
                <div class="col-lg-8 col-12 flex-info font_bold">
                    <div>{{ __('store.name') }} : <span class="font-700">{{ $pharmacy->name }}</span></div>
                    <div>{{ __('store.Mobile number') }} : <span class="font-700">{{ $pharmacy->fullPhone }}</span></div>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="profile-in font_bold mt-3 mb-3">{{ __('store.email') }} : <span class="font-700">{{ $pharmacy->email }}</span></div>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="profile-in font_bold mb-3">{{ __('store.ID Number') }} : <span class="font-700">{{ $pharmacy->identity_number }}</span></div>
                </div>

            </div>
            <div class="card-white font-17">
                <div class="top-card-flex">
                    <h4 class="font_bold font-17">{{ __('translation.Qualifications') }}</h4>
                    <button class="add-per up" type="button" data-toggle="modal" data-target="#exampleModal">{{ __('translation.Add a qualifier') }}</button>
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

                @endforelse

                <form action="{{ route('pharmacy.profile.permit.update') }}" class="form" data-type="profile" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-center mt-3 mb-3">{{ __('translation.Graduation certificate') }}</h4>
                    <div class="flex-photos ">
                        <input type="file" accept="image/*"   onchange="uploadProfileIMG(this)" id="sin-up"    class="upload-fff"
                               name="graduation_certification_image" hidden>
                        <label for="sin-up">
                            <div class="right-ph"><img src="{{ $pharmacy->graduation_certification_image }}" alt="">
                                <div class="error_show error_graduation_certification_image"> </div>
                            </div>
                        </label>


                        <div class="left-ph">
                            <label for="pdf-up">
                                <i class="fa-solid fa-pen-to-square"></i>

                            </label>
                            <input type="file" accept="application/pdf"   onchange="uploadProfilePdf(this)" id="pdf-up"    class="upload-fff"
                                   name="graduation_certification_pdf" hidden>

                           <div class="color-main">
                               <a href="{{ $pharmacy->graduation_certification_pdf }}" target="_blank">
                                   <img src="{{ asset('/') }}dashboard/imgs/pdf.png" alt="">
                               </a>
                               <div class="mt-3"></div>
                               <div class="error_show error_graduation_certification_pdf"> </div>
                           </div>
                        </div>
                    </div>

                    <h4 class="text-center mt-3 mb-3">{{ __('translation.Practice certificate') }}</h4>
                    <div class="flex-photos ">
                        <input type="file" accept="image/*"   onchange="uploadProfileIMG(this)" id="sin-up2"    class="upload-fff"
                               name="practice_certification_image" hidden>
                        <label for="sin-up2">
                            <div class="right-ph"><img src="{{ $pharmacy->practice_certification_image }}" alt="">
                                <div class="error_show error_practice_certification_image"> </div>
                            </div>
                        </label>

                        <div class="left-ph">
                            <label for="pdf-up2">
                                <i class="fa-solid fa-pen-to-square font-17"></i>

                            </label>
                            <input type="file" accept="application/pdf"   onchange="uploadProfilePdf(this)" id="pdf-up2"    class="upload-fff"
                                   name="practice_certification_pdf" hidden>
                            <div class="color-main">
                                <a href="{{ $pharmacy->practice_certification_pdf }}" target="_blank">
                                    <img src="{{ asset('/') }}dashboard/imgs/pdf.png" alt="">
                                </a>
                                <div class="mt-3"></div>
                                <div class="error_show error_practice_certification_pdf"> </div>
                            </div>
                        </div>
                    </div>


                    <h4 class="text-center mt-3 mb-3">{{ __('translation.Experience certificate') }}</h4>
                    <div class="flex-photos ">
                        <input type="file" accept="image/*"   onchange="uploadProfileIMG(this)" id="sin-up3"    class="upload-fff"
                               name="experience_certification_image" hidden>
                        <label for="sin-up3">
                            <div class="right-ph"><img src="{{ $pharmacy->experience_certification_image }}" alt="">
                                <div class="error_show error_experience_certification_image"> </div>

                            </div>
                        </label>

                        <div class="left-ph">
                            <label for="pdf-up3">
                                <i class="fa-solid fa-pen-to-square"></i>

                            </label>
                            <input type="file" accept="application/pdf" name="experience_certification_pdf"   onchange="uploadProfilePdf(this)" id="pdf-up3"    class="upload-fff" hidden>
                            <div class="color-main">
                                <a href="{{ $pharmacy->experience_certification_pdf }}" target="_blank">
                                    <img src="{{ asset('/') }}dashboard/imgs/pdf.png" alt="">
                                </a>
                                <div class="mt-3"></div>
                                <div class="error_show error_experience_certification_pdf"> </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button class="add-per up submit-button" type="submit">{{ __('store.Save changes') }}</button>
                    </div>

                </form>





            </div>
            <div class="card-white font-17">
                <div class="top-card-flex">
                    <h4 class="font_bold no-border-bottom font-17">{{ __('store.pharmacy data') }}</h4>
                    <a href="#" data-toggle="modal" data-target="#exampleModal2"><i class="fa-solid fa-pen-to-square"></i></a>
                </div>
                <div class="profile-in">{{ __('store.pharmacy address') }} : <span>{{ $firstBranch->address }}</span></div>
                <div class="profile-in">{{ __('store.pharmacy address on the map') }} : <span>{{ $firstBranch->address_map }}</span></div>
                <div class="profile-in">{{ __('store.pharmacy record number') }} : <span>{{ $firstBranch->comerical_record }}</span></div>
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
                <h4 class="font_bold mt-3 mb-3">{{ __('store.pharmacy photos') }}</h4>
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


    @include('providers_dashboards.pharmacy.profile.includes.personal-data')
    @include('providers_dashboards.pharmacy.profile.includes.permit')
    @include('providers_dashboards.pharmacy.profile.includes.branches')



    <!-- Modal 22222 -->


@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('/') }}dashboard/js/jquery.fancybox.min.js"></script>
    <script src="{{ asset('/site/') }}/flag/build/js/intlTelInput.min.js"></script>

    @include('providers_dashboards.store.includes.js.map')
    @include('providers_dashboards.store.includes.js.formAjaxRegister')
    @include('providers_dashboards.pharmacy.includes.js.profile')

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





        function uploadProfileIMG (input){



            input.nextElementSibling.querySelector("img").src = URL.createObjectURL(event.target.files[0]);




        }
        function uploadProfilePdf (input){



            input.nextElementSibling.firstElementChild.href = URL.createObjectURL(event.target.files[0]);
            input.nextElementSibling.firstElementChild.nextElementSibling.innerHTML = "{{ __('translation.Modified') }}";






        }



    </script>


@endpush
