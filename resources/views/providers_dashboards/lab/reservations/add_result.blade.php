@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">
                    <h6>@lang('localize.test_result')</h6>
                </div>
            </div>
            <div class="card-white">
                <div class="col-lg-9 col-12 mm-auto">
                    <div class="personal-data">
                        <div class="personal-row">
                            <div class="personal-row-part">
                                @lang('localize.patient_name') : <span>{{ $reservation->name }}</span>
                            </div>
                            <div class="personal-row-part">
                                @lang('localize.patient_age') : <span>{{ $reservation->age }}</span>
                            </div>
                            <div class="personal-row-part">
                                @lang('localize.blood_type') :
                                <span>{{ $reservation->reservation_for == 'family' ? $reservation->patientBloodType->name : $reservation->user->bloodType->name }}</span>
                            </div>
                        </div>
                        <div class="personal-row">
                            <div class="personal-row-part">
                                @lang('localize.gender') : <span>{{ __('doctor.' . $reservation->gender) }}</span>
                            </div>
                            <div class="personal-row-part">
                                @lang('localize.ser_num') : <span>{{ $reservation->id }}</span>
                            </div>
                            <div></div>
                        </div>
                    </div>
                    <form action="{{ route('lab.reservations.setReservationFirstResult') }}"
                        data-success="$('#staticBackdrop').modal('show')" method="POST"
                        class="form form-modal1 add-tome-if">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                        <div class="add-iff">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">@lang('localize.test_name')</h6>
                                <select name="lap_results[0][Lab_subcategory_reservation_id]" id=""
                                    class="default2-select gr">
                                    <option value="" selected disabled>
                                        @lang('localize.choose_test_department')
                                    </option>
                                    @foreach ($reservation->labSubcategoryReservationHasMany as $labResult)
                                        <option value="{{ $labResult->id }}">
                                            {{ $labResult->SubCategoryLab->labSubCategory->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error_show error_lap_results.0.Lab_subcategory_reservation_id"> </div>
                            </div>
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">@lang('localize.result')</h6>
                                <div class="form__label">
                                    <input name="lap_results[0][result]" class="default_input" type="text"
                                        placeholder="@lang('localize.pe_test_name')" />
                                    <label class="float__label" for="">@lang('localize.pe_test_name')</label>
                                </div>
                                <div class="error_show error_lap_results.0.result"> </div>

                            </div>
                            <div class="work-plus-icon plus-add00 add-spe19 add-if-btn">
                                <div class="plus-add">+</div>
                            </div>
                        </div>

                        <div class="mb-3 main-inp-cont">
                            <h6 class="fontBold mainColor font14">@lang('localize.attach_images')</h6>
                            <div class="form__label">
                                <label for="filesNext4_input" class="apload-img-reg">
                                    <input type="file" hidden multiple id="filesNext4_input" class="heddenUploud files-input"
                                        name="images[]" data-input="filesNext4" />
                                    <div class="add-photo">
                                        <i class="fa-solid fa-upload"></i>
                                    </div>
                                    <div class="img-apload-title">@lang('localize.pe_images')</div>
                                </label>
                            </div>
                            <div class="uploaded__area" id="filesNext4_cont"></div>
                            <div class="error_show error_images"> </div>

                        </div>
                        <div class="mt-3 main-inp-cont">
                            <h6 class="fontBold mainColor mb-1 font14">@lang('localize.report')</h6>
                            <label class="form__label">
                                <textarea class="default_input" name="lab_report" type="text" placeholder="@lang('localize.write_report')"></textarea>
                                <span class="float__label">@lang('localize.write_report')</span>
                            </label>
                            <div class="error_show error_report"> </div>

                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <button class="submit up mt-3 submit-button">
                                @lang('localize.save_and_print')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal 2 -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="" />
                    <div class="font_bold don-t">@lang('localize.result_sent_successfuly')</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <a class="submit up" href="{{route('lab.reservationDetails' ,$reservation->id)}}"> @lang('localize.view_result') </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
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
        let counter = 1;
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
    </script>

    @include('shared.formAjax')
@endpush
