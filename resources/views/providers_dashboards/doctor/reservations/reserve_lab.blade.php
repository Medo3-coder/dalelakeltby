@extends('providers_dashboards.layouts.dashboards.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/jquery.fancybox.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/animate.css') }}" />
@endpush

@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="card-white spe-pad">
                <div class="flex-go-right">
                    <button class="all-products font-17 book-me" data-toggle="modal" data-target="#exampleModal"
                        data-dismiss="modal">
                        <img src="{{ asset('dashboard/imgs/Group 83036.png') }}" alt="" />
                        @lang('doctor.reserve')
                    </button>
                </div>
                <div class="text-center">
                    <img class="center-small mt-3" src="{{ $lab->image }}" alt="" />
                </div>
                <h4 class="text-center font_bold mt-4 mb-4">{{ $lab->name }}</h4>
                <div class="botton-br-div">@lang('doctor.lab_info')</div>
                <div class="parameters-spe font-700 mt-3 font-16">
                    <div class="top-flex-par">
                        <div class="spe-info mb-3 mt-3">
                            <i class="fa-solid fa-location-dot"></i>
                            <div class="real-info">
                                @lang('admin.address') : {{ $lab->address }}
                            </div>
                        </div>
                        <div class="spe-info mb-3 mt-3">
                            <i class="fa-solid fa-phone"></i>
                            <div class="real-info">
                                @lang('admin.phone') : {{ $lab->phone }}

                            </div>
                        </div>
                    </div>
                    <div class="spe-info mb-3 mt-3">
                        <i class="fa-solid fa-envelope"></i>
                        @lang('admin.email') : {{ $lab->email }}
                    </div>
                </div>
                <div class="card-top mt-4">
                    <h5 class="card-top-right font_bold">{{ $labCategory->name }} @lang('doctor.available')</h5>
                    <div class="card-top-left">
                        <div class="quentity">@lang('doctor.available') <span> {{ count($labSubCategories) }} </span></div>
                    </div>
                </div>

                @for ($i = 0; $i < count($labSubCategories); $i += 2)
                    <div class="flex-rrooww">
                        @isset($labSubCategories[$i])
                            <div class="my-right font-17 font-700 mt-3 mb-3">
                                {{ $i + 1 }}/ {{ $labSubCategories[$i]->labSubCategory->name }}
                            </div>
                        @endisset

                        @isset($labSubCategories[$i + 1])
                            <div class="my-right font-17 font-700 mt-3 mb-3">
                                {{ $i + 2 }}/ {{ $labSubCategories[$i + 1]->labSubCategory->name }}
                            </div>
                        @endisset
                    </div>
                @endfor

                <div class="spe-info mb-2 font-16 font-700">
                    <i class="fa-regular fa-images"></i>
                    <div class="real-info font-16 font-700 font-17">@lang('doctor.lab_images') :</div>
                </div>
                @foreach ($lab->branches as $branch)
                    <div class="row">
                        @foreach ($branch->images as $branchImage)
                            <div class="col-lg-4 col-md-6 col-12 spe-for-img mb-3">
                                <img src="{{ $branchImage->image }}" alt="" />
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Modal 1 book a test -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe">
            <div class="modal-content">
                <div class="modal-header no-border-bottom">
                    <h5 class="modal-title font_bold modal7-spe" id="exampleModalLabel">
                        @lang('doctor.reserve_test')
                    </h5>
                </div>
                <div class="modal-body no-border-bottom modal7-spe">
                    <div class="personal-data">
                        <div class="personal-row">
                            <div class="personal-row-part">
                                @lang('site.paient_name') :
                                <span>{{ $reservation->reservation_for == 'same_person' ? $reservation->user->name : $reservation->paient_name }}</span>
                            </div>
                            <div class="personal-row-part">
                                @lang('doctor.patient_age') :
                                <span>{{ $reservation->reservation_for == 'same_person' ? $reservation->user->age : $reservation->paient_age }}</span>
                            </div>
                            <div class="personal-row-part">
                                @lang('doctor.bloodType') :
                                <span>{{ $reservation->reservation_for == 'same_person' ? $reservation->user->bloodType->name : $reservation->patientBloodType->name }}</span>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('doctor.reservations.sendPatientToLab') }}"
                        class="form-modal1 form">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                        <input type="hidden" name="lab_id" value="{{ request()->lab }}">
                        <input type="hidden" name="lab_category_id" value="{{ request()->lab_category }}">
                        <div class="mb-3 main-inp-cont">
                            <h6 class="fontBold mainColor font14">@lang('doctor.test_type')</h6>
                            <div class="input_select">
                                <select name="sub_category_lab_id[]" class="select2 multiple_select" multiple="multiple"
                                    required>
                                    <option class="firts-op" value="" disabled>
                                        @lang('doctor.choose') @lang('doctor.test_type')
                                    </option>
                                    @foreach ($labSubCategories as $labSubCategory)
                                        <option value="{{ $labSubCategory->id }}">
                                            {{ $labSubCategory->labSubCategory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="main-inp-cont">
                            <h6 class="fontBold mainColor font14">@lang('doctor.reservation_date')</h6>
                            <div class="inp-date-con">
                                <input name="date" type="datetime-local" required id="myDate"
                                    placeholder="@lang('doctor.choose') @lang('doctor.date')" class="default-date-inp3" />
                                <i class="fa-regular fa-calendar date-inp3"></i>
                            </div>
                        </div>
                        <div class="main-inp-cont mt-3">
                            <h6 class="fontBold mainColor font14">@lang('doctor.reservation_time')</h6>
                            <div class="inp-date-con">
                                <input name="time" type="time" required id="myTime"
                                    placeholder="@lang('doctor.choose') @lang('doctor.time')" class="default-date-inp3" />
                                <i class="fa-regular fa-clock position-absolute  date-inp3"></i>
                            </div>
                        </div>
                        <div class="mb-3 mt-3 main-inp-cont">
                            <h6 class="fontBold mainColor font14">@lang('doctor.notes')</h6>
                            <div class="form__label">
                                <input name="details" class="default_input" type="text" required=""
                                    placeholder="@lang('doctor.can_send_notes_to_lab')" />
                                <label class="float__label" for="">@lang('doctor.can_send_notes_to_lab')</label>
                            </div>
                        </div>
                        <button class="submit submit-form submit_button wid-70 mt-4 up" type="submit">
                            @lang('doctor.confirm_reservation')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 3 booked -->
    <div class="modal fade" id="staticBackdrop3" tabindex="-1" aria-labelledby="staticBackdrop2Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{asset('dashboard/imgs/7717-successful.gif')}}" alt="" />
                    <div class="font_bold don-t">@lang('doctor.lab_reserved')</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">
                            @lang('site.done')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('dashboard/js/select2.js') }}"></script>

    <script>
        let select2s = document.querySelector(".select2");
        if (select2s) {
            $(document).ready(function() {
                $(".select2").select2();
            });
        }
    </script>
    <script>
        flatpickr("#myDate", {
            disableMobile: "true",
        });
        flatpickr("#myTime", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            // static: true
        });

        $(document).ready(function() {
            $(document).on('submit', '.form', function(e) {
                var old_content = $(".submit_button").html()
                e.preventDefault();
                var url = $(this).attr('action')
                $.ajax({
                    url: url,
                    method: 'post',
                    data: new FormData($(this)[0]),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        old_content = $(".submit_button").html()
                        $(".submit_button").html(
                            '<div class="w-100 d-flex justify-content-center text-center"><div class="submit-loader"></div></div>'
                        ).attr('disable', true);
                    },
                    success: (response) => {
                        $(".submit_button").html(old_content).attr('disable', false)
                        if (response.status != 'success') {
                            toastr.error(response.msg)
                        } else {
                            $('#exampleModal').modal('hide');
                            $('#staticBackdrop3').modal('show');
                            setTimeout(() => {
                               window.location.replace(`{{route('doctor.reservations.details' ,$reservation->id)}}`); 
                            }, 2000);
                        }
                    },
                    error: () => {
                        $(".submit_button").html(old_content).attr('disable', false)
                    }
                });

            });
        });
    </script>
@endpush
