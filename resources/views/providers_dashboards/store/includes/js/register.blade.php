
{{--Maps--}}
<script>

    // var input = document.querySelector("#telephone");
    // let iti = window.intlTelInput(input, {
    //     autoPlaceholder: "ادخل",
    //     customPlaceholder: "kggg",
    //     initialCountry: "sa",
    //     separateDialCode: true,
    // });

    $("#telephone").on('countrychange', function(){
        var countryDialCode = iti.getSelectedCountryData().dialCode;
        var countryCode = $('#country_code');
        countryCode.val(countryDialCode);
    });

    var countryDialCode = iti.getSelectedCountryData().dialCode;
    var countryCode = $('#country_code');
    countryCode.val(countryDialCode);

    function mapLocation(map, lat, lng, address){
        $(map).locationpicker({
            inputBinding: {
                latitudeInput: $(lat),
                longitudeInput: $(lng),
                locationNameInput: $(address),
                enableAutocomplete: true,
            },

            location: {
                latitude:$(lat).val() ,
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

    $('.maps').each(function (key, value){
        console.log(value);
        var map = $(this).find('.map');
        var lat = $(this).find('.lat')
        var lng = $(this).find('.lng')
        var address = $(this).find('.address')

        mapLocation(map, lat, lng, address);
    })
</script>


{{--<script>--}}
{{--    var input = document.querySelector("#telephone");--}}
{{--    var iti = window.intlTelInput(input, {--}}
{{--        autoPlaceholder: "ادخل",--}}
{{--        customPlaceholder: "kggg",--}}
{{--        initialCountry: "sa",--}}
{{--        // nationalMode:false,--}}
{{--        separateDialCode: true,--}}
{{--        geoIpLookup:function (callback) {--}}
{{--        },--}}
{{--    });--}}



<script>
    var loadFiles = function(event) {
        var images = document.getElementById("change-profile");
        images.src = URL.createObjectURL(event.target.files[0]);
    };
</script>

{{--</script>--}}
<!------------abload files------------->
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
<!------------step-wizard------------->
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


<script>
    let plusBtn = document.querySelectorAll(".work-plus-icon");
    // let workParent = document.querySelector(".work-parent");

    for (let i = 0; i < plusBtn.length; i++) {
        plusBtn[i].addEventListener("click", function() {
            console.log(plusBtn[i]);
            let addit = `
     <div class="row g-2 relative-parent times-cont">
                           <div class="input-work col-6 col-sm-6 col-md-4 mb-3">
                               <div class='input-icon'>
                                   <select name="times[days-0][]" id="" class="default_input">
                                        <option value="saturday">{{ __('store.saturday') }}</option>
                                        <option value="sunday">{{ __('store.sunday') }}</option>
                                        <option value="monday">{{ __('store.monday') }}</option>
                                        <option value="tuesday">{{ __('store.tuesday') }}</option>
                                        <option value="wednesday">{{ __('store.wednesday') }}</option>
                                        <option value="thursday">{{ __('store.thursday') }}</option>
                                        <option value="friday">{{ __('store.friday') }}</option>
                                   </select>

                               </div>
                           </div>
                           <div class="input-work col-6 col-sm-6 col-md-4 mb-3">
                               <input type="text" name="times[from-0][]" placeholder="{{ __('store.from') }}" class='from-date'>
                           </div>
                           <div class="input-work col-6 col-sm-6 col-md-4 mb-3">
                               <input type="text" name="times[from-0][]" placeholder="{{ __('store.to') }}" class='to-date'>
                           </div>
                           <div class="work-close-icon" onclick="deleteDate2(this)" ">
                               <i class="fa-solid fa-xmark"></i>
                           </div>
                       </div>
     `;

            this.previousElementSibling.append(addit);
        });
    }

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

    function deleteDate(el) {
        el.parentElement.parentElement.remove();
    }
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


<!--another select-->
<script>
    let allselects = document.querySelectorAll(".another-sh-select");
    // let alldivs = document.querySelectorAll(".show-another");
    for (let i = 0; i < allselects.length; i++) {
        allselects[i].addEventListener("change", function() {
            if (
                this.options[this.selectedIndex].dataset.another === "another-sh-sp"
            ) {
                this.parentElement.nextElementSibling.nextElementSibling.style.display =
                    "block";
            }
        });
    }

</script>
<!--big append-->
<script>
    var myCount = 1;

    function appendAll() {
        let myAllDiv = `

        <div class="spe-append-map">
          <div class="mb-3 main-inp-cont">
    <input type="hidden" name="index" value="${myCount}">
                        <h6 class="fontBold mainColor font14">{{ __('store.branch_name') }}</h6>
                        <div class="form__label error_names">
                          <input
                            class="default_input"
                            type="text"
                            name="name-${myCount}"
                            placeholder="{{ __('store.branch_name_val') }}"
                          />
                          <label class="float__label" for=""
                            >{{ __('store.branch_name_val') }}</label
                          >
                        </div>
                         <div class="error_show error_name-${myCount}"> </div>
                      </div>
                      <div class="mb-3 main-inp-cont">
                        <h6 class="fontBold mainColor font14">{{ __('store.branch_address') }}</h6>
                        <div class="form__label">
                          <input class="default_input" name="address-${myCount}" type="text"  placeholder="{{ __('store.branch_address_val') }}" />
                          <label class="float__label" for=""
                            >{{ __('store.branch_address_val') }}</label
                          >
                        </div>
                         <div class="error_show error_address-${myCount}"> </div>
                      </div>
<div class="maps">
                      <div class="mb-3 main-inp-cont">
                        <h6 class="fontBold mainColor font14">
                          {{ __('store.branch_address_map') }}
                        </h6>
                        <div class="form__label">
                        <input class="default_input address-${myCount}" name="address_map-${myCount}" readonly type="text"  placeholder="{{ __('store.branch_address_map_val') }}"  />

                          <label class="float__label" for=""
                            >{{ __('store.branch_address_map_val') }}</label
                          >
                          <div class="add-photo">
                            <i class="fa-solid fa-location-dot"></i>
                          </div>
                        </div>
                      </div>
                      <div  style="width: 100%; height: 320px" class="mb-3 map-${myCount}"></div>
                        <input type="hidden" name="lat-${myCount}" class="lat-${myCount}" value="31.04035945880287">
                    <input type="hidden" name="lng-${myCount}" class="lng-${myCount}" value="31.37892723083496">
<div class="maps">
                      <div class="mb-3 main-inp-cont">
                        <h6 class="fontBold mainColor font14">
                          {{ __('store.branch_record_number') }}
                        </h6>
                        <div class="form__label">
                          <input class="default_input" name="comerical_record-${myCount}" type="number"  placeholder=" {{ __('store.branch_record_number_val') }}" />
                          <label class="float__label" for=""
                            >{{ __('store.branch_record_number_val') }}</label
                          >
                        </div>
                         <div class="error_show error_comerical_record-${myCount}"> </div>
                      </div>
                      <div class="groups-inp">
                        <div class="mb-3 main-inp-cont">
                          <h6 class="fontBold mainColor font14">
                            {{ __('store.Branch opening certificate (photo)') }}
                          </h6>
                          <div class="form__label">
                            <label
                              for="${"filesNext2" + myCount + "_input"}"
                              class="apload-img-reg"
                            >
                              <input
                                type="file"
                                hidden
                                id="${"filesNext2" + myCount + "_input"}"
                                class="heddenUploud files-input"
                                name="opening_certificate_image-${myCount}"
                                data-input="${"filesNext2" + myCount}"
                                accept="image/*"
                              />
                              <div class="add-photo">
                                <i class="fa-solid fa-images"></i>
                              </div>
                              <div class="img-apload-title">
                                {{ __('store.Please enter a copy of the branch opening certificate') }}
                              </div>
                            </label>
                          </div>
                         <div class="error_show error_opening_certificate_image-${myCount}"> </div>
                          <div
                            class="uploaded__area"
                            id="${"filesNext2" + myCount + "_cont"}"
                          ></div>
                        </div>
                        <div class="mb-3 main-inp-cont">
                          <h6 class="fontBold mainColor font14">
                            {{ __('store.PDF branch opening certificate') }}
                          </h6>
                          <div class="form__label">
                            <label
                            for="${"filesNext3" + myCount + "_input"}"
                              class="apload-img-reg"
                            >
                              <input
                                type="file"
                                hidden
                                id="${"filesNext3" + myCount + "_input"}"
                                class="heddenUploud files-input"
                                name="opening_certificate_pdf-${myCount}"
                                data-input="${"filesNext3" + myCount}"
                                multiple
                                accept="application/pdf"
                              />
                              <div class="add-photo">
                                <i class="fa-solid fa-upload"></i>
                              </div>
                              <div class="img-apload-title">
                                {{ __('store.Please enter the branch opening certificate') }}
                              </div>
                            </label>
                          </div>
                         <div class="error_show error_opening_certificate_pdf-${myCount}"> </div>
                          <div
                            class="uploaded__area"
                            id="${"filesNext3" + myCount + "_cont"}"
                          ></div>
                        </div>
                      </div>
                      <div class="mb-3 main-inp-cont">
                        <h6 class="fontBold mainColor font14">{{ __('store.Branch photos') }}</h6>
                        <div class="form__label">
                          <label for="${
            "filesNext4" + myCount + "_input"
        }" class="apload-img-reg">
                            <input
                              type="file"
                              hidden
                              multiple
                              data-single="true"
                              id="${"filesNext4" + myCount + "_input"}"
                              class="heddenUploud files-input"
                              name="images-${myCount}[]"
                              data-input="${"filesNext4" + myCount}"
                              accept="image/*"
                            />
                            <div class="add-photo">
                              <i class="fa-solid fa-images"></i>
                            </div>
                            <div class="img-apload-title">
                              {{ __('store.Please enter branch photos') }}
                            </div>
                          </label>
                        </div>
                         <div class="error_show error_images-${myCount}"> </div>
                        <div class="uploaded__area" id="${
            "filesNext4" + myCount + "_cont"
        }"></div>
                      </div>
                      <div
                        class="work-date-container form-section-style main-inp-cont"
                      >
                        <h6 class="fontBold mainColor font14">{{ __('store.times of work') }}</h6>

                        <div class="work-date-content ">
                          <div class="work-parent work-parent row g-0 times-cont">
                            <div class="work-date col-md-12">
                              <div class="row g-2">
                                <div class="input-work col-6 col-sm-6 col-md-4">
                                  <div class="input-icon">
                                    <select name="times[days-${myCount}][]" id="" class="default_input">
                                     <option value="saturday">{{ __('store.saturday') }}</option>
                                        <option value="sunday">{{ __('store.sunday') }}</option>
                                        <option value="monday">{{ __('store.monday') }}</option>
                                        <option value="tuesday">{{ __('store.tuesday') }}</option>
                                        <option value="wednesday">{{ __('store.wednesday') }}</option>
                                        <option value="thursday">{{ __('store.thursday') }}</option>
                                        <option value="friday">{{ __('store.friday') }}</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="input-work col-6 col-sm-6 col-md-4">
                                  <input
                                    type="text"
                                    placeholder="{{ __('store.from') }}"
                                    class="from-date"
                                    id=""
                                    name="times[from-${myCount}][]"
                                  />
                                  <label class="add-photo" for="time1">
                                    <i class="fa-regular fa-clock"></i>
                                  </label>
                                </div>
                                <div class="input-work col-6 col-sm-6 col-md-4">
                                  <input
                                    type="text"
                                    placeholder="{{ __('store.to') }}"
                                    class="to-date"
                                    id=""
                                    name="times[to-${myCount}][]"
                                  />
                                  <label class="add-photo" for="time2">
                                    <i class="fa-regular fa-clock"></i>
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="work-plus-icon">
                            <div class="plus-add">{{ __('store.add new') }}</div>
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

        // recall abload files again

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

        // add work dainamic

        let plusBtn = document.querySelectorAll(".work-plus-icon");
        // let workParent = document.querySelector(".work-parent");

        for (let i = 0; i < plusBtn.length; i++) {
            plusBtn[i].addEventListener("click", function() {
                console.log(plusBtn[i]);
                let addit = `
     <div class="row g-2 relative-parent times-cont">
                           <div class="input-work col-6 col-sm-6 col-md-4 mb-3">
                               <div class='input-icon'>
                                   <select name="times[days-${myCount}][]" id="" class="default_input">
                                                    <option value="saturday">{{ __('store.saturday') }}</option>
                                        <option value="sunday">{{ __('store.sunday') }}</option>
                                        <option value="monday">{{ __('store.monday') }}</option>
                                        <option value="tuesday">{{ __('store.tuesday') }}</option>
                                        <option value="wednesday">{{ __('store.wednesday') }}</option>
                                        <option value="thursday">{{ __('store.thursday') }}</option>
                                        <option value="friday">{{ __('store.friday') }}</option>
                                   </select>

                               </div>
                           </div>
                           <div class="input-work col-6 col-sm-6 col-md-4 mb-3">
                               <input type="text" name="times[from-${myCount}][]" placeholder="{{ __('store.from') }}" class='from-date'>
                               <label class="add-photo">
                                      <i class="fa-regular fa-clock"></i>
                              </label>
                           </div>
                           <div class="input-work col-6 col-sm-6 col-md-4 mb-3">
                               <input type="text" name="to[from-${myCount}][]" placeholder="{{ __('store.to') }}" class='to-date'>
                               <label class="add-photo">
                                      <i class="fa-regular fa-clock"></i>
                              </label>
                           </div>
                           <div class="work-close-icon"  onclick="deleteDate2(this)">
                               <i class="fa-solid fa-xmark"></i>
                           </div>
                       </div>
     `;
                // $(this).prev(".work-date").append(addit);
                this.previousElementSibling.insertAdjacentHTML("afterend", addit);
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
            });
        }


        myCount++;
    }

    function deleteDate2(el) {
        el.closest(".relative-parent").remove();
    }
</script>
<script>
    let plusBtn2 = document.querySelector(".work-plus-icon22");
    let workParent = document.querySelector(".work-parent2");

    plusBtn2.addEventListener("click", function() {
        let dateRow = document.createElement("div");

        dateRow.innerHTML = `
                      <div class="row g-2 relative-parent times-cont">
                          <div class="input-work col-6 col-sm-6 col-md-4">
                              <div class='input-icon'>
                                       <select name="times[days-0][]" id="" class="default_input">
                                                    <option value="saturday">{{ __('store.saturday') }}</option>
                                        <option value="sunday">{{ __('store.sunday') }}</option>
                                        <option value="monday">{{ __('store.monday') }}</option>
                                        <option value="tuesday">{{ __('store.tuesday') }}</option>
                                        <option value="wednesday">{{ __('store.wednesday') }}</option>
                                        <option value="thursday">{{ __('store.thursday') }}</option>
                                        <option value="friday">{{ __('store.friday') }}</option>

                                  </select>

                              </div>
                          </div>
                          <div class="input-work col-6 col-sm-6 col-md-4">
                              <input type="text" name="times[from-0][]" placeholder="{{ __('store.from') }}" class='from-date'>
                              <label class="add-photo">
                                      <i class="fa-regular fa-clock"></i>
                              </label>
                          </div>
                          <div class="input-work col-6 col-sm-6 col-md-4">
                              <input type="text" name="times[to-0][]" placeholder="{{ __('store.to') }}" class='to-date'>
                              <label class="add-photo">
                                      <i class="fa-regular fa-clock"></i>
                              </label>
                          </div>
                          <div class="work-close-icon" onclick="deleteDate(this)" ">
                              <i class="fa-solid fa-xmark"></i>
                          </div>
                      </div>
                  `;

        dateRow.classList.add("work-date", "col-md-12");
        workParent.append(dateRow);

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
    });

    function deleteDate(el) {
        el.parentElement.parentElement.remove();
    }
</script>