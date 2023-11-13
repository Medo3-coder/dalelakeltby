@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <style>
        .delete-in-edit-parent {
            opacity: .5;
        }
    </style>
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">

                    <h6>@lang('site.control_panel')</h6>
                    <div class="links-top-to">
                        <a>@lang('site.reservations')</a> /
                        <a href="{{ route('lab.acceptedReservations') }}">@lang('site.accepted_reservations')</a> /
                        <span class="color-main">@lang('site.reservation_details')</span>
                    </div>
                </div>


                @if ($reservation->status == 'new')
                    <div class="d-inline-block">
                        <button type="button" class="accept_order table-btn-spe d-inline w-auto mx-1 main-bg up"
                            data-url="{{ route('lab.acceptReservation', $reservation->id) }}">
                            @lang('site.accept_order')
                        </button>

                        <button type="button" class="refuse_order table-btn-spe d-inline w-auto mx-1 danger-bg up danger-h"
                            data-toggle="modal" data-target="#staticBackdrop" data-reservation_id="{{ $reservation->id }}">
                            @lang('site.cancel_order')
                        </button>
                    </div>
                @elseif ($reservation->labSubcategoryReservationHasMany->where('result', '!=', null)->count() > 0)
                    <form action="{{ route('lab.reservations.finishReservation', $reservation->id) }}" class="form"
                        method="POST">
                        @csrf
                        @method('put')
                        <button class="submit-button test-result up">
                            <i class="fa-solid fa-calendar-days"></i>@lang('localize.finish_order')
                        </button>
                    </form>
                @elseif ($reservation->status == 'on_progress')
                    <a href="{{ route('lab.reservations.addReservationResult', $reservation->id) }}" class="test-result up">
                        <i class="fa-solid fa-calendar-days"></i>@lang('site.reservation_results')
                    </a>
                @endif

            </div>
            <div class="card-white righ-left-p-0">
                <h6 class="row-tab-m">@lang('site.reservation_details')</h6>
                <div class="card-white-button">
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('site.name')</div>
                            <div class="name-card">{{ $reservation->name }}</div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('site.reservation_time')</div>
                            <div class="name-card">{{ $reservation->date->format('H:i A') }}</div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('site.age')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_for == 'family' ? $reservation->age : $reservation->user->age }}
                            </div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('site.reservation_date')</div>
                            <div class="name-card">{{ $reservation->date->format('d-m-Y') }}</div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('site.blood_type')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_for == 'family' ? $reservation->patientBloodType->name : $reservation->user->bloodType->name }}
                            </div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('site.transfer_from_doctor')</div>
                            <div class="name-card">{{ $reservation->doctor_id != null ? __('site.yes') : __('site.no') }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('localize.weight')</div>
                            <div class="name-card">{{ $reservation->weight }}</div>
                        </div>
                        @if ($reservation->doctor)
                            <div class="row-left">
                                <div class="name-card color-gray">@lang('localize.doctor_name')</div>
                                <div class="name-card">{{ $reservation->doctor->name }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('localize.length')</div>
                            <div class="name-card">{{ $reservation->height }}</div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('localize.notes')</div>
                            <div class="name-card">{{ $reservation->details ?? __('localize.not_found') }}</div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('localize.gender')</div>
                            <div class="name-card">{{ __('doctor.' . $reservation->gender) }}</div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('localize.app_commition')</div>
                            <div class="name-card">{{ $reservation->admin_commission_amount . ' ' . __('site.currency') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-white">
                <h5>@lang('localize.required_tests')</h5>
                @foreach ($reservation->labSubCategories as $test)
                    <p>{{ $test->labSubCategory->name }}</p>
                @endforeach
                <h5 class="mt-3">@lang('localize.test_details')</h5>
                <p>{{ $reservation->details }}</p>
            </div>

            @if ($reservation->labSubcategoryReservationHasMany->where('result', '!=', null)->count() > 0)
                <div class="card-white text-center">
                    <div class="top-buttom">
                        <h5>@lang('localize.result_of_the_test')</h5>
                        <a href="" class="test-result-spe up" data-toggle="modal" data-target="#EditResultsModal">
                            <i class="fa-solid fa-calendar-days"></i>
                            @lang('localize.edit+_result')
                        </a>
                    </div>
                    <a href="#" class="test-result-big up" data-toggle="modal" data-target="#viewResultModal">
                        <i class="fa-solid fa-book-open"></i>
                        @lang('localize.show__test_result')
                    </a>
                </div>
            @endif
        </div>
    </main>


    @include('providers_dashboards.lab.reservations.details._accept_and_reject_modals')

    @include('providers_dashboards.lab.reservations.details._edit_result_modals')

    @include('providers_dashboards.lab.reservations.details._view_result_model')
@endsection
@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>

    <script>
        $(document).on('click', '.refuse_order', function() {
            $('#reservation_id').val($(this).data('reservation_id'))
        });
    </script>

    <script>
        $(document).on('click', '.accept_order', function() {
            var url = $(this).data('url')
            $.ajax({
                url: url,
                method: 'get',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: (response) => {
                    if (response.status != 'success') {
                        toastr.error(response.msg)
                    } else {
                        $('#staticBackdrop2').modal('show');
                        setTimeout(() => {
                            window.location.reload()
                        }, 1500);
                    }
                },
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', '.form-accept', function(e) {
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
                            $('#staticBackdrop').modal('hide');
                            $('#staticBackdrop3').modal('show');
                            setTimeout(() => {
                                window.location.replace(
                                    "{{ route('lab.newReservations') }}")
                            }, 1500);
                        }
                    },
                    error: () => {
                        $(".submit_button").html(old_content).attr('disable', false)
                    }
                });

            });
        });
    </script>
    {{-- staticBackdrop2 --}}

    <script>
        let inputsFiles = {};
        $(".files-input").on("change", function(event) {
            let input = $(this).data("input");
            const selectedFilesCont = document.getElementById(input + "_cont");
            if (!!inputsFiles[input]) {
                let files = new DataTransfer();
                for (let i = 0; i < event.target.files.length; i++) {
                    files.items.add(event.target.files[i]);
                }
                for (let i = 0; i < inputsFiles[input].length; i++) {
                    files.items.add(inputsFiles[input][i]);
                }
                inputsFiles[input] = files.files;
                selectedFilesCont.innerHTML = "";
            } else {
                inputsFiles[input] = event.target.files;
            }
            if (!!inputsFiles[input] && inputsFiles[input].length > 0) {
                if ($(this).data("single") == true) {
                    selectedFilesCont.innerHTML = "";
                    inputsFiles[input] = event.target.files;
                }
                for (let i = 0; i < inputsFiles[input].length; i++) {
                    const fileType = inputsFiles[input][i].type.split("/")[0];
                    if (fileType === "image") {
                        let src = URL.createObjectURL(inputsFiles[input][i]);
                        $("#" + input + "_cont").append(` <div class="file_">
                                                      <a data-fancybox="gallery" href="${src}">
                                                          <img src="${src}" alt="">
                                                      </a>
                                                      <div class="btn remove_media" onclick="deleteFile(this ,'${inputsFiles[input][i].name}' ,'${input}')"><ion-icon name="close-outline"></ion-icon></div>
                                                  </div>`);
                    } else if (fileType === "video") {
                        let src = URL.createObjectURL(inputsFiles[input][i]);

                        $("#" + input + "_cont").append(`<div class="file_">
                                                      <a data-fancybox="gallery" data-type="video" href="${src}">
                                                          <video controls>
                                                              <source src="${src}" type="video/mp4">
                                                          </video>
                                                          <div class="play-button"><i class="fas fa-play-circle"></i></div>
                                                      </a>
                                                      <div class="btn remove_media" onclick="deleteFile(this ,'${inputsFiles[input][i].name}' ,'${input}')"><ion-icon name="close-outline"></ion-icon></div>
                                                  </div>`);
                    } else {
                        $("#" + input + "_cont").append(`<div class="file_">
                                                      <div class="docs_file">
                                                          <div class="d-flex flex-column align-items-center justify-content-center h-100 p-2">
                                                              <span class="font10">${inputsFiles[input][i].name}</span>
                                                              <span><i class="far fa-file-pdf mr-1 ml-1"></i></span>
                                                          </div>
                                                      </div>
                                                      <div class="btn remove_media" onclick="deleteFile(this ,'${inputsFiles[input][i].name}' ,'${input}')"><ion-icon name="close-outline"></ion-icon></div>
                                                  </div>`);
                    }
                }
            }
            event.target.files = inputsFiles[input];
        });

        function deleteFile(ele, name, input) {
            let filesInput = document.getElementById(input + "_input");
            let files = new DataTransfer();
            let deleted = null;
            for (let i = 0; i < filesInput.files.length; i++) {
                if (filesInput.files[i].name == name && deleted != name) {
                    deleted = name;
                    continue;
                }
                files.items.add(filesInput.files[i]);
            }
            filesInput.files = files.files;
            inputsFiles[input] = files.files;

            // edit the number of parents to delete
            $(ele).parent().remove();
        }
    </script>
    <!------------append------------->
    <script>
        let addBtn = document.querySelector(".add-if-btn");
        let counter = {{ $reservation->labSubcategoryReservationHasMany->where('result', '!=', null)->count() }};
        addBtn.addEventListener("click", function() {
            let additionIf = `
        <div class="add-if">
            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">@lang('localize.test_name')</h6>
                                <select name="lap_results[${counter}][Lab_subcategory_reservation_id]" id=""
                                    class="default2-select gr">
                                    <option value="" selected disabled>
                                        @lang('localize.choose_test_department')
                                    </option>
                                    @foreach ($reservation->labSubcategoryReservationHasMany as $labResult)
                                        <option value="{{ $labResult->id }}">
                                            {{ $labResult->SubCategoryLab->labSubCategory->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error_show error_lap_results.${counter}.Lab_subcategory_reservation_id"> </div>
                            </div>
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">@lang('localize.result')</h6>
                                <div class="form__label">
                                    <input name="lap_results[${counter}][result]" class="default_input" type="text" 
                                        placeholder="@lang('localize.pe_test_name')" />
                                    <label class="float__label" for="">@lang('localize.pe_test_name')</label>
                                </div>
                                <div class="error_show error_lap_results.${counter}.result"> </div>
                            </div>
                <div class="work-plus-icon plus-add00 add-spe19 add-if-btn remove-defi2" onclick="removeElement(this)">
                  <div class="add-plus"><i class="fa fa-times"></i></div>
                </div>
              </div>
        `;
            $(".add-iff").append(additionIf);
            disableUsedOptions();
            counter++;
        });

        function removeElement(rmButton) {
            $(rmButton).closest(".add-if").remove();
            disableUsedOptions();
        }


        function disableUsedOptions() {
            $selects = $("select");
            $selects.on("change", function() {
                $selects = $("select");

                if ($selects.length <= 1) return;
                let selected = [];

                $selects.each(function(index, select) {
                    if (select.value !== "") {
                        selected.push(select.value);
                    }
                });

                $("option").prop("disabled", false);
                for (var index in selected) {
                    $('option[value="' + selected[index] + '"]:not(:selected)')
                        .prop("disabled", true);
                }
            });
            $selects.trigger("change");
        }
        disableUsedOptions();

        $('.deleted_images').on('click', function() {
            $(this).parent().parent().toggleClass('delete-in-edit-parent');
        });
    </script>

    @include('shared.formAjax')
@endpush
