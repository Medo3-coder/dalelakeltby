<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&key={{ $settings['google_places'] }}&libraries=places&language={{ app()->getLocale() }}"></script>

<script src="{{ asset('dashboard/js/location-picker.js') }}"></script>


<script>
    function mapLocation(map, lat, lng, address) {
        $(map).locationpicker({
            inputBinding: {
                latitudeInput: $(lat),
                longitudeInput: $(lng),
                locationNameInput: $(address),
                enableAutocomplete: true,
            },

            location: {
                latitude: $(lat).val(),
                longitude: $(lng).val()
            },

        });
        navigator.geolocation.getCurrentPosition(function(position) {
            $(map).locationpicker('location', {
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                inputBinding: {
                    latitudeInput: $(lat),
                    longitudeInput: $(lng),
                    locationNameInput: $(address)
                },
            });
        });
    }

    $('.maps').each(function(key, value) {
        console.log(value);
        var map = $(this).find('.map');
        var lat = $(this).find('.lat')
        var lng = $(this).find('.lng')
        var address = $(this).find('.address')

        mapLocation(map, lat, lng, address);
    })
</script>



<script>
    let inputsFiles = {};

    function abloadDefi(inputgo) {
        let input = inputgo.dataset.input;

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
            console.log(inputsFiles[input]);
            if ($(inputgo).data("single") == true) {
                console.log("single");
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
    }

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


<script>
    $(document).ready(function() {
        $(".nav-tabs > li a[title]").tooltip();

        //Wizard
        $('a[data-toggle="tab"]').on("shown.bs.tab", function(e) {
            var target = $(e.target);

            if (target.parent().hasClass("disabled")) {
                return false;
            }
        });

        $(".next-step").click(function(e) {
            var active = $(".wizard .nav-tabs li.active");
            active.next().removeClass("disabled");
            nextTab(active);
        });
        $(".prev-step").click(function(e) {
            var active = $(".wizard .nav-tabs li.active");
            prevTab(active);
        });
    });

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }

    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }

    $(".nav-tabs").on("click", "li", function() {
        $(".nav-tabs li.active").removeClass("active");
        $(this).addClass("active");
    });
</script>

<!-- Flat Picker -->
<script>
    flatpickr(".from-date", {
        disableMobile: "true",
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });
    flatpickr(".to-date", {
        disableMobile: "true",
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
    });
</script>


<!--set wow js-->
<script>
    new WOW().init();
</script>

<!--big append-->
<script>
    var myCount = 1;

    function appendAll() {
        console.log(myCount);
        let myAllDiv = `

      <div class="spe-append-map">
            
                    <div class="mb-3 main-inp-cont">
                        <h6 class="fontBold mainColor font14">@lang('localize.lab_name')</h6>
                        <div class="form__label">
                            <input class="default_input" name="branches[${myCount}][name]" type="text" required=""
                                placeholder="@lang('localize.pe_lab_name')" />
                            <label class="float__label" for="">@lang('localize.pe_lab_name')</label>
                        </div>
                        <div class="error_show error_branches.${myCount}.name"> </div>
                    </div>

                          <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">
                {{ __('translation.lab_address') }}
        </h6>
        <div class="form__label">
            <input class="default_input" name="branches[${myCount}}][address]" type="text"  placeholder="{{ __('translation.lab_address_val') }}" />
                <label class="float__label" for="">{{ __('translation.lab_address_val') }}</label>
            </div>
            <div class="error_show error_branches.${myCount}.address"> </div>
        </div>

                    <div class="mb-3 main-inp-cont">
            <div class="maps">
                <div class="mb-3 main-inp-cont">
                    <h6 class="fontBold mainColor font14">
                        @lang('localize.lab_location_on_map')
                    </h6>
                    <div class="form__label">
                        <input type="hidden" name="branches[${myCount}][lat]" class="lat-${myCount}" value="31.04035945880287">
                        <input type="hidden" name="branches[${myCount}][lng]" class="lng-${myCount}" value="31.37892723083496">
                        <input class="default_input address-${myCount}" name="branches[${myCount}][address_map]" readonly type="text"
                            placeholder="{{ __('store.store_address_map_val') }}t" />
                        <label class="float__label" for="">{{ __('store.store_address_map_val') }}</label>
                        <div class="add-photo">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                </div>
                <div id="" style="width: 100%; height: 320px" class="mb-3 map-${myCount}"></div>
            </div>
            <div class="error_show error_branches.${myCount}.lat"> </div>
            <div class="error_show error_branches.${myCount}.lng"> </div>
            <div class="error_show error_branches.${myCount}.address"> </div>
        </div>
                    <div class="mb-3 main-inp-cont">
                      <h6 class="fontBold mainColor font14">
                        @lang('localize.lab_comerical_number')
                      </h6>
                      <div class="form__label">
                        <input
                          class="default_input"
                          type="number"
                          required=""
                          placeholder=" @lang('localize.pe_lab_comerical_number')" 
                          name="branches[${myCount}][comerical_record]"
                        />
                        <label class="float__label" for="">@lang('localize.pe_lab_comerical_number')</label>

                      </div>
                      <div class="error_show error_branches.${myCount}.comerical_record"> </div>
                    </div>

                    <div class="groups-inp">

                        <div class="mb-3 main-inp-cont">
                            <h6 class="fontBold mainColor font14">@lang('localize.lab_open_cerificate_image')</h6>
                            <div class="form__label ">
                                <label for="filesNext_image_${myCount}_input" class="apload-img-reg">
                                    <div class="add-photo">
                                        <i class="fa-solid fa-images"></i>
                                    </div>
                                    <div class="img-apload-title">
                                        @lang('localize.lab_open_cerificate_image')
                                    </div>
                                </label>
                                <input type="file" onchange="abloadDefi(this)" hidden id="filesNext_image_${myCount}_input"
                                    class="heddenUploud files-input" data-single="true" name="branches[${myCount}][opening_certificate_image]" data-input="filesNext_image_${myCount}"
                                    accept="image/*" />
                            </div>
                            <div class="error_show error_branches.${myCount}.opening_certificate_image"> </div>

                            <div class="uploaded__area" id="filesNext_image_${myCount}_cont"></div>
                        </div>



                        <div class="mb-3 main-inp-cont">
                            <h6 class="fontBold mainColor font14">@lang('localize.lab_open_certificate_pdf')</h6>
                            <div class="form__label ">
                                <label for="filesNext_pdf_${myCount}_input" class="apload-img-reg">
                                    <div class="add-photo">
                                        <i class="fa-solid fa-images"></i>
                                    </div>
                                    <div class="img-apload-title">
                                        @lang('localize.lab_open_certificate_pdf')
                                    </div>
                                </label>
                                <input type="file" onchange="abloadDefi(this)" hidden id="filesNext_pdf_${myCount}_input"
                                    class="heddenUploud files-input" data-single="true" name="branches[${myCount}][opening_certificate_pdf]" data-input="filesNext_pdf_${myCount}"
                                    accept=".pdf" />
                            </div>
                            <div class="error_show error_branches.${myCount}.opening_certificate_pdf"> </div>

                            <div class="uploaded__area" id="filesNext_pdf_${myCount}_cont"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3 main-inp-cont">
                      <h6 class="fontBold mainColor font14">
                        @lang('localize.lab_images')
                    </h6>
                      <div class="form__label">
                        <label for="${"filesNext4" + myCount + "_input"}" class="apload-img-reg">
                          <input
                            type="file"
                            hidden
                            onchange="abloadDefi(this)"
                            id="${"filesNext4" + myCount + "_input"}"
                            class="heddenUploud files-input"
                            name="branches[${myCount}][images][]"
                            data-input="${"filesNext4" + myCount}"
                            multiple
                            accept="image/*"
                          />
                          <div class="add-photo">
                            <i class="fa-solid fa-images"></i>
                          </div>
                          <div class="img-apload-title">
                            @lang('localize.pe_lab_images')
                          </div>
                        </label>
                      </div>
                      <div class="uploaded__area" id="${"filesNext4" + myCount + "_cont"}"></div>
                      <div class="error_show error_branches.${myCount}.images"> </div>

                    </div>
                    <div
                      class="work-date-container form-section-style main-inp-cont"
                    >
                      <h6 class="fontBold mainColor font14">@lang('localize.working_times')</h6>

                      <div class="work-date-content">
                      <div class="work-parent2 row g-0">
                          <div class="work-date times-cont col-md-12">
                              <div class="row g-2">
                                  <div class="input-work col-6 col-sm-6 col-md-4">
                                      <div class="input-icon">
                                          <select name="branches[${myCount}][dates][0][day]" class="default_input">
                                              <option value="saturday">@lang('localize.sat')</option>
                                              <option value="sunday">@lang('localize.sun')</option>
                                              <option value="monday">@lang('localize.mon')</option>
                                              <option value="tuesday">@lang('localize.tue')</option>
                                              <option value="wednesday">@lang('localize.wen')</option>
                                              <option value="thursday">@lang('localize.thu')</option>
                                              <option value="friday">@lang('localize.fri')</option>
                                          </select>
                                      </div>
                                      <div class="error_show error_branches.${myCount}.dates.0.day"> </div>

                                  </div>
                                  <div class="input-work col-6 col-sm-6 col-md-4">
                                      <input type="text" name="branches[${myCount}][dates][0][from]" placeholder="@lang('localize.from')"
                                          class="from-date" id="" />
                                      <label class="add-photo" for="time1">
                                          <i class="fa-regular fa-clock"></i>
                                      </label>
                                      <div class="error_show error_branches.${myCount}.dates.0.from"> </div>

                                  </div>
                                  <div class="input-work col-6 col-sm-6 col-md-4">
                                      <input type="text" name="branches[${myCount}][dates][0][to]" placeholder="@lang('localize.to')"
                                          class="to-date" id="" />
                                      <label class="add-photo" for="time2">
                                          <i class="fa-regular fa-clock"></i>
                                      </label>
                                      <div class="error_show error_branches.${myCount}.dates.0.to"> </div>

                                  </div>
                              </div>
                          </div>
                      </div>

                <div class="work-plus-icon22" onclick="appendDateMain(this ,${myCount})">
                    <div class="plus-add">@lang('localize.add_new')</div>
                </div>
                <div class="error_show error_branches.${myCount}.dates"> </div>
                <div onclick="$(this).parent().parent().parent().remove()" class="btn btn-danger">
                    <div class="plus-add2 mb-3">
                        <i class="fa fa-trash"></i></div>
                </div>

            </div>
                    </div>
      </div>
    `;
        $(".add-append").append(myAllDiv);

        var map = $('.map-' + myCount);
        var lat = $('.lat-' + myCount)
        var lng = $('.lng-' + myCount)
        var address = $('.address-' + myCount)

        mapLocation(map, lat, lng, address);

        // Call flatpickr again after adding a new row
        flatpickr(".from-date", {
            disableMobile: "true",
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
        flatpickr(".to-date", {
            disableMobile: "true",
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });


        myCount++;
    }

    function deleteDate2(el) {
        el.closest(".relative-parent").remove();
    }
</script>

<!--add new work-->

<script>
    let datesCounter = 1;

    function appendDateMain(dateMain, index) {
        let dateRow = document.createElement("div");

        dateRow.innerHTML = `
                    <div class="row g-2 relative-parent">
                      <div class="input-work col-6 col-sm-6 col-md-4">
                              <div class="input-icon">
                                  <select name="branches[${index}][dates][${datesCounter}][day]" class="default_input">
                                      <option value="saturday">@lang('localize.sat')</option>
                                      <option value="sunday">@lang('localize.sun')</option>
                                      <option value="monday">@lang('localize.mon')</option>
                                      <option value="tuesday">@lang('localize.tue')</option>
                                      <option value="wednesday">@lang('localize.wen')</option>
                                      <option value="thursday">@lang('localize.thu')</option>
                                      <option value="friday">@lang('localize.fri')</option>
                                  </select>
                                  <div class="error_show error_branches.${index}.dates.${datesCounter}.day"> </div>

                              </div>
                          </div>
                          <div class="input-work col-6 col-sm-6 col-md-4">
                              <input type="text" name="branches[${index}][dates][${datesCounter}][from]" placeholder="@lang('localize.from')"
                                  class="from-date" id="" />
                              <label class="add-photo" for="time1">
                                  <i class="fa-regular fa-clock"></i>
                              </label>
                              <div class="error_show error_branches.${index}.dates.${datesCounter}.from"> </div>

                          </div>
                          <div class="input-work col-6 col-sm-6 col-md-4">
                              <input type="text" name="branches[${index}][dates][${datesCounter}][to]" placeholder="@lang('localize.to')"
                                  class="to-date" id="" />
                              <label class="add-photo" for="time2">
                                  <i class="fa-regular fa-clock"></i>
                              </label>
                              <div class="error_show error_branches.${index}.dates.${datesCounter}.to"> </div>

                          </div>
                        <div class="work-close-icon" onclick="deleteDate(this)" ">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                `;
        datesCounter++;

        dateRow.classList.add("work-date", "col-md-12");
        dateMain.previousElementSibling.append(dateRow);

        // Call flatpickr again after adding a new row
        flatpickr(".from-date", {
            disableMobile: "true",
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
        flatpickr(".to-date", {
            disableMobile: "true",
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
        });
    }

    function deleteDate(el) {
        el.parentElement.parentElement.remove();
    }
</script>

</script>
