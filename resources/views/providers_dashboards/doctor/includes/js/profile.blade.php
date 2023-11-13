<!--map-->

<script>

    function mapUpdate(map, lat, lng, address){
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
    }

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
        var map = $(this).find('.map');
        var lat = $(this).find('.lat')
        var lng = $(this).find('.lng')
        var address = $(this).find('.address')

        mapUpdate(map, lat, lng, address);
    })
</script>

{{--Delete Account--}}
<script>
    function deleteAccount(el){
        event.preventDefault();
        Swal.fire({
            icon: 'info',
            iconColor: '#2f71b3',
            title: '<h5 class="font_bold">'+ "{{ __('store.Do you want to delete the account?') }}" +'</h5>',
            showDenyButton: true,
            showCancelButton: true,
            showConfirmButton: false,
            denyButtonText: '{{ __('store.delete') }}',
            cancelButtonText:'{{ __('store.cancel') }}'
        }).then((result)=>{
            if (result.isDenied) {

                $(el).ajaxSubmit({
                    url: '{{ route('doctor.profile.store.delete') }}',
                    method:"POST",
                    data:{
                        _token:'{{ csrf_token() }}',
                        _method:'DELETE',
                    },
                    success: (response) => {
                        if(response.status == 'success'){
                            Swal.fire({
                                icon: 'success',
                                iconColor: '#2f71b3',
                                showConfirmButton: false,
                                title: '<h5 class="font_bold">'+ response.msg +'</h5>',

                            })
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        }else {
                            Swal.fire({
                                icon: 'error',
                                iconColor: '#ff0000',
                                title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                                showConfirmButton: true,
                                confirmButtonText: '{{ __('store.ok') }}',

                            })
                        }

                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            iconColor: '#ff0000',
                            title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                            showConfirmButton: true,
                            confirmButtonText: '{{ __('store.ok') }}',

                        })
                    },
                });

            }
        })
    }
</script>

{{--Delete Permit--}}
<script>
    function deletePermit(el){
        event.preventDefault();
        var id = $(el).data('val');
        Swal.fire({
            icon: 'info',
            iconColor: '#2f71b3',
            title: '<h5 class="font_bold">'+ "{{ __('translation.Do you want to delete the qualification?') }}" +'</h5>',
            showDenyButton: true,
            showCancelButton: true,
            showConfirmButton: false,
            denyButtonText: '{{ __('store.delete') }}',
            cancelButtonText:'{{ __('store.cancel') }}'
        }).then((result)=>{
            if (result.isDenied) {

                $(el).ajaxSubmit({
                    url: '{{ route('doctor.profile.permit.delete') }}',
                    method:"POST",
                    data:{
                        _token:'{{ csrf_token() }}',
                        _method:'DELETE',
                        id:id
                    },
                    success: (response) => {
                        if(response.status == 'success'){
                            Swal.fire({
                                icon: 'success',
                                iconColor: '#2f71b3',
                                showConfirmButton: false,
                                title: '<h5 class="font_bold">'+ response.msg +'</h5>',

                            })
                            setTimeout(function () {
                                window.location.reload();
                            }, 3000);
                        }else {
                            Swal.fire({
                                icon: 'error',
                                iconColor: '#ff0000',
                                title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                                showConfirmButton: true,
                                confirmButtonText: '{{ __('store.ok') }}',

                            })
                        }

                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            iconColor: '#ff0000',
                            title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                            showConfirmButton: true,
                            confirmButtonText: '{{ __('store.ok') }}',

                        })
                    },
                });

            }
        })
    }
</script>


<script>
    let inputsFiles = {};
    function abloadDefi(inputgo) {
        let input = inputgo.dataset.input;

        const selectedFilesCont = document.getElementById(input + "_cont");
        console.log(selectedFilesCont);
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

<!--add new work-->

<script>
    function appendDateMain(dateMain, myCount) {
        let dateRow = document.createElement("div");

        dateRow.innerHTML = `
                    <div class="row g-2 relative-parent">
                        <div class="input-work  col-6 col-sm-6 col-md-4">
                            <div class='input-icon'>
                                <select name="times[days-${myCount}][]" id="" class="default_input">
                                        <option value="saturday" >{{ __('store.saturday') }}</option>
                                        <option value="sunday" >{{ __('store.sunday') }}</option>
                                        <option value="monday" >{{ __('store.monday') }}</option>
                                        <option value="tuesday" >{{ __('store.tuesday') }}</option>
                                        <option value="wednesday" >{{ __('store.wednesday') }}</option>
                                        <option value="thursday">{{ __('store.thursday') }}</option>
                                        <option value="friday">{{ __('store.friday') }}</option>
                                </select>

                            </div>
                        </div>
                        <div class="input-work col-6 col-sm-6 col-md-4">
                            <input type="text" name="times[from-${myCount}][]" value="" placeholder="{{ __('store.from') }}" class="from-date from" id="" />
                            <label class="add-photo">
                                    <i class="fa-regular fa-clock"></i>
                            </label>
                        </div>
                        <div class="input-work col-6 col-sm-6 col-md-4">
                            <input type="text" name="times[to-${myCount}][]" value="" placeholder="{{ __('store.to') }}" class="to-date ro" id="" />
                            <label class="add-photo">
                                    <i class="fa-regular fa-clock"></i>
                            </label>
                        </div>
                        <div class="work-close-icon" onclick="deleteDate(this)" ">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                    </div>
                `;

        dateRow.classList.add("work-date", "col-md-12", 'times-cont');
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





<!--load photo-->
<script>
    var loadFiles = function (event) {
        var images = document.getElementById("change-profile");
        images.src = URL.createObjectURL(event.target.files[0]);
    };
</script>

<!--big append-->
<script>
    function appendAll() {
        var myCount = $('.branches').length;
        console.log(myCount);
        let myAllDiv = `
<div class="branches">
      <div class="spe-append-map position-relative ">
        <div class="work-close-icon mb-5 top-def" onclick="deleteall(this)"><i class="fa-solid fa-xmark"></i></div>
        <div class="mb-3 main-inp-cont">
        <input type="hidden" name="index[]" value="${myCount}">
        <input type="hidden" name="ids[${myCount}]" value="0">


              <div class="spe-append-map position-relative ">
                                    <div class="mb-3 main-inp-cont">
                                        <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.name') }}</h6>
                                        <div class="form__label">
                                            <input class="default_input" type="text" name="name[${myCount}]" value=""  placeholder="{{ __('doctor.doctor.name_val') }}" />
                                            <label class="float__label" for="">{{ __('doctor.doctor.name_val') }}</label>
                                        </div>
                                    </div>
                                    <div class="error_show error_name[${myCount}]"> </div>
                                </div>

                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.address') }}</h6>
                                    <div class="form__label">
                                        <input class="default_input" type="text" name="address[${myCount}]" value=""  placeholder="{{ __('doctor.doctor.address_val') }}" />
                                        <label class="float__label" for="">{{ __('doctor.doctor.address_val') }}</label>
                                    </div>
                                    <div class="error_show error_address[${myCount}]"> </div>
                                </div>

                                <div class="maps">
                                    <div class="mb-3 main-inp-cont">
                                        <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.address_map') }}</h6>
                                        <div class="form__label">
                                            <input readonly class="default_input address-${myCount}" type="text" name="address_map[${myCount}]" value=""  placeholder="{{ __('doctor.doctor.address_map_val') }}" />
                                            <label class="float__label" for="">{{ __('doctor.doctor.address_map_val') }}</label>
                                        </div>
                                      <div class="error_show error_address_map[${myCount}]"> </div>
                                    </div>

                                    <div
                                            id=""
                                            style="width: 100%; height: 300px"
                                            class="mb-3 map-${myCount}"
                                    ></div>
                                    <input type="hidden" class="lat-${myCount}" name="lat[${myCount}]" value="31.0388256">
                                    <input type="hidden" class="lng-${myCount}" name="lng[${myCount}]" value="31.3827617">
                                </div>

                                    <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.comerical_record') }}</h6>
                                    <div class="form__label">
                                        <input class="default_input" name="comerical_record[]" value="" type="number"  placeholder="{{ __('doctor.doctor.comerical_record_val') }}" />
                                        <label class="float__label" for="">{{ __('doctor.doctor.comerical_record_val') }}</label>
                                    </div>
                                    <div class="error_show error_comerical_record[${myCount}]"> </div>
                                </div>

                                   <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('doctor.detection_price') }}</h6>
                                    <div class="form__label">
                                        <input class="default_input" name="detection_price[${myCount}]" value="" type="number"  placeholder="{{ __('doctor.detection_price_val') }}" />
                                        <label class="float__label" for="">{{ __('doctor.detection_price_val') }}</label>
                                    </div>
                                    <div class="error_show error_detection_price[${myCount}]"> </div>
                                </div>

                    <div class="mb-3 main-inp-cont">
                      <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.images') }}</h6>
                      <div class="form__label">
                        <label for="${"filesNext4" + myCount + "_input"
        }" class="apload-img-reg">
                          <input
                            type="file"
                            onchange="abloadDefi(this)"
                            hidden
                            multiple
                            id="${"filesNext4" + myCount + "_input"}"
                            class="heddenUploud files-input"
                            name="${"images-" + myCount + "[]"}"
                            data-input="${"filesNext4" + myCount}"
                            accept="image/*"
                          />
                          <div class="add-photo">
                            <i class="fa-solid fa-images"></i>
                          </div>
                          <div class="img-apload-title">
                            {{ __('doctor.doctor.images_val') }}
                          </div>
                        </label>
                      </div>
                      <div class="error_show error_images-${myCount}"> </div>
                      <div class="uploaded__area" name="images-${myCount}" id="${"filesNext4" + myCount + "_cont"
        }"></div>
                    </div>
                    <div
                      class="work-date-container form-section-style main-inp-cont"
                    >
                      <h6 class="fontBold mainColor font14">{{ __('store.store_times') }}</h6>

                      <div class="work-date-content ">
                        <div class="work-parent row g-0">
                          <div class="work-date times-cont col-md-12">
                            <div class="row g-2">
                              <div class="input-work col-6 col-sm-6 col-md-4">
                                <div class="input-icon">
                                      <select name="times[days-${myCount}][]" id="" class="default_input">
                                        <option value="saturday" >{{ __('store.saturday') }}</option>
                                        <option value="sunday" >{{ __('store.sunday') }}</option>
                                        <option value="monday" >{{ __('store.monday') }}</option>
                                        <option value="tuesday" >{{ __('store.tuesday') }}</option>
                                        <option value="wednesday" >{{ __('store.wednesday') }}</option>
                                        <option value="thursday">{{ __('store.thursday') }}</option>
                                        <option value="friday">{{ __('store.friday') }}</option>
                                    </select>
                                </div>
                              </div>
                              <div class="input-work col-6 col-sm-6 col-md-4">
                              <input type="text" name="times[from-${myCount}][]" value="" placeholder="{{ __('store.from') }}" class="from-date from" id="" />
                                <label class="add-photo" for="time1">
                                  <i class="fa-regular fa-clock"></i>
                                </label>
                              </div>
                              <div class="input-work col-6 col-sm-6 col-md-4">
                                <input type="text" name="times[to-${myCount}][]" value="" placeholder="{{ __('store.to') }}" class="to-date to" id="time2" />
                                <label class="add-photo" for="time2">
                                  <i class="fa-regular fa-clock"></i>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="work-plus-icon" onclick="appendDateMain(this, ${myCount})">
                          <div class="plus-add">{{ __('store.add new') }}</div>
                        </div>
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

        // set a mab with current location
// set a mab with current location




        myCount++;
    }


    function deleteDate2(el) {
        el.closest(".relative-parent").remove();
    }
    function deleteall(all) {
        all.closest(".spe-append-map").remove();
    }

    function deleteBranch(el) {
        el.closest(".branches").remove();
    }

    function deleteImage(el){

        el.closest('.file_').remove();
    }
</script>

