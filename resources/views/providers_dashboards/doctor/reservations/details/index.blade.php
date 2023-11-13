@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">
                    <h6>@lang('doctor.dashboard')</h6>
                    <div class="links-top-to">
                        <a>@lang('doctor.reservations')</a> /
                        <a href="{{ route('doctor.reservations.accepted') }}">@lang('doctor.accepted_reservations')</a> /
                        <span class="color-main">@lang('doctor.reservation_details')</span>
                    </div>
                </div>
                @if (!in_array($reservation->status, ['new', 'approved']))
                    <div class="mb-2 nice-flex">
                        @if ($reservation->status == 'transfer_to_lab')
                            <a class="test-result  accept-patient follow followed followed2 no-hover">
                                <img src="{{ asset('dashboard/imgs/Group 83289.png') }}" alt="" />
                                @lang('doctor.patient_sent_to_lab')
                            </a>
                        @elseif ($reservation->status !== 'finished')
                            <a href="{{ route('doctor.reservations.chooseLab', $reservation->id) }}"
                                class="test-result sentToLab no-hover">
                                <img src="{{ asset('dashboard/imgs/Group 83289.png') }}" alt="" />
                                @lang('doctor.tranfere_to_lab')
                            </a>

                            <a href="#" class="test-result no-hover" data-toggle="modal" data-target="#exampleModal">
                                <img src="{{ asset('dashboard/imgs/Group 82986.png') }}" alt="" />
                                @lang('doctor.write_receipt')
                            </a>
                        @endif
                    </div>
                @endif
            </div>
            <div class="card-white righ-left-p-0">
                <h6 class="row-tab-m">@lang('doctor.reservation_info')</h6>
                <div class="card-white-button font-700">
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('site.name')</div>
                            <div class="name-card">
                                {{ $reservation->name }}
                            </div>
                        </div>
                        @if ($reservation->reservation_for == 'same_person')
                            <div class="row-left">
                                <div class="name-card color-gray">@lang('doctor.gender')</div>
                                <div class="name-card">@lang('doctor.' . $reservation->user->gender)</div>
                            </div>
                        @endif
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.age')</div>
                            <div class="name-card">
                                {{ $reservation->age }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.bloodType')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_for == 'same_person' ? $reservation->user->bloodType->name : $reservation->patientBloodType->name }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.weight')</div>
                            <div class="name-card">
                                {{ $reservation->weight }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.length')</div>
                            <div class="name-card">
                                {{ $reservation->height }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.reservation_time')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_time }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.reservation_date')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_date }}
                            </div>
                        </div>
                    </div>
                    @if ($reservation->clinic)
                        <div class="row1">
                            <div class="row-right">
                                <div class="name-card color-gray">@lang('doctor.address')</div>
                                <div class="name-card color-main">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    {{ $reservation->clinic->name }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.notes')</div>
                            <div class="name-card">
                                {{ $reservation->notes ?? __('doctor.not_found') }}
                            </div>
                        </div>
                    </div>

                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.app_commission')</div>
                            <div class="name-card">
                                {{ $reservation->admin_commission_amount . ' ' . __('site.currency') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-white text-center">
                <div class="top-buttom">
                    <h5>@lang('doctor.medical_record')</h5>
                </div>
                <div class="last-one-flex">
                    <a href="#" class="test-result-big no-hover" data-toggle="modal" data-target="#exampleModal4">
                        <img src="{{ asset('dashboard/imgs/Group 82989.png') }}" alt="" />
                        @lang('doctor.show_personal_record')
                    </a>
                    <a href="#" class="test-result-big no-hover" data-toggle="modal" data-target="#exampleModal5">
                        <img src="{{ asset('dashboard/imgs/Group 82989.png') }}" alt="" />
                        @lang('doctor.show_family_record')
                    </a>
                </div>
            </div>

            @if ($reservation->children->where('status', 'finished')->count() > 0)
                <div class="card-white">
                    <div class="top-buttom">
                        <h5>
                            @lang('doctor.lab_result')
                        </h5>
                    </div>
                    <div class="flex-me-center">
                        <a href="#" class="test-result-big no-hover" data-toggle="modal" data-target="#exampleModal6">
                            <img src="{{ asset('dashboard/imgs/Group 82989.png') }}" alt="" />
                            @lang('doctor.show_lab_result')
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </main>


    @include('providers_dashboards.doctor.reservations.details._write_prescription_model')

    <!-- Modal 2 -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal15-spe text-center">
                    <img class="show-img-mm" src="../lab dashboard/imgs/NoPath - Copy (84).png" alt="" />
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit mt-4" data-dismiss="modal">
                            تم
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 double -->
    <div class="modal fade" id="staticBackdropdouble" tabindex="-1" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal15-spe text-center">
                    <img class="show-img-mm2" src="{{ asset('dashboard/imgs/NoPath - Copy (84).png') }}"
                        alt="" />
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit mt-4" data-dismiss="modal">
                            @lang('doctor.done')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('providers_dashboards.doctor.reservations.details._family_medical_record_model')

    @include('providers_dashboards.doctor.reservations.details._add_new_ragete_model')

    @include('providers_dashboards.doctor.reservations.details._personal_medical_record_model')

    {{--  @include('providers_dashboards.doctor.reservations.details._print_prescription_model')  --}}
    <!-- Modal 3 -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModal3Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe">
            <div class="modal-content">
                <div class="modal-header no-border-bottom close-modal">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="perciptionModel" class="modal-body no-border-bottom modal2-spe font-16 print-doctor">

                    <div class="flex-ticket-btn mt-3">
                        <button class="up next-print font-bold doctor-p">@lang('doctor.print')</button>
                        @isset($nextReservationId)
                            <a href="{{ route('doctor.reservations.details', ['reservation_id' => $nextReservationId, 'next_patient' => 1]) }}"
                                class="bg-green up next-print">@lang('doctor.next_patient')</a>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('providers_dashboards.doctor.reservations.details._lab_results_model')
@endsection
@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        flatpickr("#myDate", {
            disableMobile: "true",
        });
    </script>


{{--    <script>--}}
{{--        let myShowBtn = document.querySelectorAll(".per-label");--}}

{{--        let newImg = document.querySelector('.abb-img-spe');--}}
{{--        // let newImg3 = document.querySelector('.ro-img-spe');--}}


{{--        let newImg22 = document.querySelector('.show-img-mm2');--}}


{{--        for (let i = 0; i < myShowBtn.length; i++) {--}}
{{--            myShowBtn[i].addEventListener("click", function() {--}}
{{--                newImg.src = this.parentElement.nextElementSibling.src;--}}

{{--                newImg22.src = this.parentElement.nextElementSibling.src;--}}
{{--                // newImg3.src = this.parentElement.nextElementSibling.src;--}}
{{--            });--}}
{{--        }--}}
{{--    </script>--}}
{{--    <script>--}}
{{--        let myShowBtn2 = document.querySelectorAll(".show-sh");--}}
{{--        let newImg2 = document.querySelector('.show-img-mm');--}}

{{--        let newImg3 = document.querySelector('.ro-img-spe');--}}



{{--        for (let i = 0; i < myShowBtn2.length; i++) {--}}
{{--            myShowBtn2[i].addEventListener("click", function() {--}}
{{--                newImg3.src = this.nextElementSibling.src;--}}
{{--                newImg2.src = this.nextElementSibling.src;--}}
{{--            });--}}
{{--        }--}}
{{--    </script>--}}
    <script>
        let myShowBtn = document.querySelectorAll(".per-label2");

        let newImg = document.querySelector('.show-img-mm');


        for (let i = 0; i < myShowBtn.length; i++) {
            myShowBtn[i].addEventListener("click", function () {
                newImg.src = this.parentElement.nextElementSibling.src;

            });
        }

    </script>
    <script>
        document
            .querySelector(".doctor-p")
            .addEventListener("click", function() {
                window.print();
            });
    </script>
    <script>
        function addClonedMedicine() {
            let clonedMedicine = `
    <div class="main-clone-me">
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">@lang('doctor.medicine')</h6>
                                <select name="medicines[]" required id="" class="default2-select gr">
                                    <option value="" selected disabled>
                                        @lang('doctor.choose_medicine')
                                    </option>
                                    @foreach (provider('doctor')->medicines as $medicine)
                                        <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                    @endforeach
                                </select>
                                </div>
              <div class="grid-cart grid-cart22">
                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">@lang('doctor.every_hm_hour')</h6>
                                    <select name="hours[]" required id="" class="default2-select gr">
                                        <option value="" selected disabled>
                                            @lang('doctor.select_dose_time')
                                        </option>
                                        <option value=".5">@lang('doctor.half_hour')</option>
                                        <option value="1">@lang('doctor.hour')</option>
                                        @for ($i = 2; $i <= 24; $i++)
                                            <option value="{{ $i }}"> {{ $i }} @lang('doctor.hour')</option>
                                        @endfor
                                        @for ($i = 24; $i < 24 * 7; $i += 24)
                                            <option value="{{ $i }}"> {{ $i / 24 }} @lang('doctor.day')</option>
                                        @endfor
                                        <option value="168">
                                            @lang('doctor.week')
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">@lang('doctor.number_of_times')</h6>
                                    <select name="times[]" required id="" class="default2-select gr">
                                        <option value="" selected disabled>
                                            @lang('doctor.select_number_of_times')
                                        </option>
                                        <option value="1">@lang('doctor.single_time')</option>
                                        <option value="2">@lang('doctor.two_times')</option>
                                        <option value="3">3 @lang('doctor.number_times')</option>
                                        <option value="4">4 @lang('doctor.number_times')</option>
                                        <option value="5">5 @lang('doctor.number_times')</option>
                                        <option value="6">6 @lang('doctor.number_times')</option>
                                    </select>
                                </div>
                <div class="work-plus-icon remove-defi2 wid-med" onclick="removeClonedMedicine(this)">
                   <div class="plus-add "><i class="fa-solid fa-xmark"></i></div>
                </div>
              </div>
            
            </div>

    `;

            $(".main-clone-to-me").append(clonedMedicine);
        }

        function removeClonedMedicine(rmButton, optionIndex) {
            $(rmButton).closest(".main-clone-me").remove();
        }
    </script>

    <script>
        $(document).on('click', '.sentToLab', function() {
            var url = $(this).data('url')
            $.ajax({
                url: url,
                method: 'put',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: (response) => {
                    if (response.status != 'success') {
                        toastr.error(response.msg)
                    } else {
                        $(this).removeClass("unfollowed");
                        $(this).addClass("followed");
                        $(this).addClass("followed2");
                        $(this).removeClass("followed3");
                        $(this).html(`@lang('doctor.patient_entered')`);
                        getData({
                            'searchArray': searchArray()
                        });
                    }
                },
            });
        });

        $('select[name="is_charnic_disease"]').on('change', function() {
            if ($(this).val() == 1) {
                $('.chranic_disease_cont').slideDown();
                $('.chranic_disease_cont').find('select').attr('disabled', false)
            } else {
                $('.chranic_disease_cont').slideUp();
                $('.chranic_disease_cont').find('select').attr('disabled', true)
            }
        });

        var loadFiles = function(event) {
            var images = document.getElementById("change-profile");
            images.src = URL.createObjectURL(event.target.files[0]);
        };


        // use this code with ajax


        function addrejeeimg(){
            // $(document).on("click", ".show-sh input", function () {
            //     $(".ro-img-spe").attr("src", $(this).parent().next().attr("src"));
            //     console.log('llllllll')
            // });
            $(".ro-img-spe").attr("src", $(".show-sh input[type='radio']:checked").parent().next().attr("src"));
            //$(".abb-img-spe").attr("src", $(".show-sh2 input[type='radio']:checked").parent().next().attr("src"));



        }
    </script>


    @include('shared.formAjax')
@endpush
