@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/jquery.fancybox.min.css" />

    <style>
        .hidden{
            display: none;
        }
    </style>
@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>{{ __('store.add_product') }}</h6>
                <div class="links-top-to">
                    <a href="{{ route('store.products') }}">{{ __('store.products') }}</a>  /
                    <span class="color-main">{{ __('store.add_product') }}</span>
                </div>
            </div>
            <form action="{{ route('store.products.store') }}" id="form" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                <div class="card-ins">
                    <div class="card-white">
                        <h4 class="font_bold mb-4 spe-border">{{ __('store.New product data') }}</h4>

                        <div class="col-12 col-lg-8 flex-add-new mb-4">
                            <div class="right-go-up">
                                <img id="change-profile" src="{{ asset('/') }}dashboard/imgs/Group 46059.png" alt="">
                                <label for="img-up" class="new-product-upload-spe">
                                    <input type="file"       onchange="loadFiles(event)"
                                           name="image"
                                           id="img-up"
                                           hidden>
                                    <i class="fa-solid fa-camera"></i>
                                </label>
                            </div>
                            <div class="left-go-up">
                                <div class="font_bold">{{ __('store.product image') }}</div>
                                <div class="text-secondary"></div>
                            </div>

                        </div>
                        <div class="error_show error_image"> </div>

                        @foreach (languages() as $lang)
                            <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.product_name_' . $lang) }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="text"
                                        name="name[{{ $lang }}]"
                                        placeholder="{{ __('site.write') .  ' ' . __('store.product_name_' . $lang) }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.write') . ' ' . __('store.product_name_' . $lang) }}</label
                                >
                            </div>
                            <div class="error_show error_name.{{ $lang }}"> </div>
                        </div>
                        @endforeach

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">

                            <h6 class="fontBold mainColor font14">{{ __('store.Product price') }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="number"
                                        step=".01"
                                        name="price"
                                        placeholder="{{ __('store.write') }} {{ __('store.Product price') }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.write') }} {{ __('store.Product price') }}</label
                                >
                            </div>
                            <div class="error_show error_price"> </div>

                        </div>
                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.Product price after discount') }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="number"
                                        step=".01"
                                        name="discount_price"
                                        placeholder="{{ __('store.write') }} {{ __('store.Product price after discount') }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.write') }} {{ __('store.Product price after discount') }}</label
                                >

                            </div>
                            <div class="error_show error_discount_price"> </div>

                        </div>
                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.from') }}</h6>
                            <label class="form__label">
                            <input type="date" id="from" placeholder="{{ __('store.choose') }} {{ __('store.date') }} {{ __('store.from') }}"  aria-invalid="false" name="from" class="default_input">
                                <label class="float__label" for=""
                                >{{ __('store.choose') }} {{ __('store.date') }} {{ __('store.from') }}</label
                                >

                            </label>
                            <div class="error_show error_from"> </div>

                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.to') }}</h6>
                            <label class="form__label">
                                <input type="date" id="from" placeholder="{{ __('store.choose') }} {{ __('store.date') }} {{ __('store.to') }}"  aria-invalid="false" name="to" class="default_input">
                                <label class="float__label" for=""
                                >{{ __('store.choose') }} {{ __('store.date') }} {{ __('store.to') }}</label
                                >

                            </label>
                            <div class="error_show error_to"> </div>

                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.date of supply') }}</h6>
                            <label class="form__label">
                                <input type="date" id="date_of_supply" placeholder="{{ __('store.choose') }} {{ __('store.date of supply') }}"  aria-invalid="false" name="date_of_supply" class="default_input">
                                <label class="float__label" for=""
                                >{{ __('store.choose') }} {{ __('store.date of supply') }}</label
                                >

                            </label>
                            <div class="error_show error_date_of_supply"> </div>

                        </div>



                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.category') }}</h6>
                            <select name="category_type" id="category_type" class="default2-select gr">
                                <option value="" selected disabled>{{ __('store.choose') }} {{ __('store.category') }}</option>
                                <option value="medicine">{{ __('store.medicine') }}</option>
                                <option value="equipment">{{ __('store.equipment') }}</option>
                            </select>
                            <div class="error_show error_category_type"> </div>

                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8 activeSubstances">
                            <h6 class="fontBold mainColor font14">{{ __('store.Active substances') }}</h6>
                            <label class="form__label">
                                <input type="text" id="active_substances" placeholder="{{ __('store.write') }} {{ __('store.Active substances') }}"   name="effective_material" class="default_input">
                                <label class="float__label" for=""
                                >{{ __('store.write') }} {{ __('store.Active substances') }}</label
                                >

                            </label>
                            <div class="error_show error_effective_material"> </div>

                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.stocked') }}</h6>
                            <select name="in_stock_type" id="" class="default2-select gr">
                                <option value="" selected disabled>{{ __('store.choose') }} {{ __('store.stocked') }}</option>
                                <option value="in">{{ __('store.in') }} {{ __('store.stocked') }}</option>
                                <option value="out">{{ __('store.run out') }} {{ __('store.stocked') }}</option>
                            </select>
                            <div class="error_show error_in_stock_type"> </div>
                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.SKU (Stock Keeping Unit)') }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="text"
                                        name="in_stock_sku"
                                        placeholder="{{ __('store.choose') }} {{ __('store.SKU (Stock Keeping Unit)') }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.choose') }} {{ __('store.SKU (Stock Keeping Unit)') }}</label
                                >

                            </div>
                            <div class="error_show error_in_stock_sku"> </div>

                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.Quantity in stock') }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="text"
                                        name="in_stock_qty"
                                        placeholder="{{ __('store.write') }} {{ __('store.Quantity in stock') }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.write') }} {{ __('store.Quantity in stock') }}</label
                                >

                            </div>
                            <div class="error_show error_in_stock_qty"> </div>

                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.product status') }}</h6>
                            <select name="available" id="" class="default2-select gr">
                                <option value="" selected disabled>{{ __('store.choose') }} {{ __('store.product status') }}</option>
                                <option value="true">{{ __('store.available') }}</option>
                                <option value="false">{{ __('store.Unavailable') }}</option>
                            </select>
                            <div class="error_show error_available"> </div>

                        </div>

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.Product Type') }}</h6>
                            <select name="type" id="" class="default2-select gr">
                                <option value="" selected disabled>{{ __('store.choose') }} {{ __('store.Product Type') }}</option>
                                <option value="simple">{{ __('store.basic') }}</option>
                                <option value="multiple">{{ __('store.Multi character') }}</option>
                            </select>
                            <div class="error_show error_type"> </div>

                        </div>


                        @foreach (languages() as $lang)
                            <div class="mt-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor mb-1 font14">{{ __('store.product_desc_' . $lang) }}</h6>
                            <label class="form__label">
                              <textarea
                                      class="default_input"
                                      type="text"
                                        name="desc[{{ $lang }}]"
                                      placeholder="{{ __('store.write') }} {{ __('store.product_desc_' . $lang) }}"
                              ></textarea>
                                <span class="float__label">{{ __('store.write') }} {{ __('store.product_desc_' . $lang) }}</span>
                            </label>
                            <div class="error_show error_desc[{{ $lang }}]"> </div>

                        </div>
                        @endforeach

                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">
                                {{ __('store.Product pictures') }}
                            </h6>
                            <div class="form__label">
                                <label for="filesNext2_input" class="apload-img-reg">
                                    <input type="file" hidden id="filesNext2_input" class="heddenUploud files-input" name="images[]" multiple data-input="filesNext2" accept="image/*" />
                                    <div class="add-photo">
                                        <i class="fa-solid fa-images"></i>
                                    </div>
                                    <div class="img-apload-title">
                                        {{ __('store.choose') }} {{ __('store.Product pictures') }}
                                    </div>
                                </label>
                            </div>
                            <div class="error_show error_images"> </div>
                            <div class="error_show error_images[]"> </div>
                            <div class="uploaded__area" id="filesNext2_cont"></div>
                        </div>

                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" id="submit-button" class="submit up mt-3 mr-2 text-center submit-button">{{ __('store.Add confirmation') }}</button>
                </div>
            </form>
        </div>


    </main>

@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/{{ app()->getLocale() }}.js"></script>
    <script src="{{ asset('/') }}dashboard/js/jquery.fancybox.min.js"></script>

    <script>
        flatpickr("#from", {
            disableMobile: "true",
            locale: "{{ app()->getLocale() }}",
        });
        flatpickr("#to", {
            disableMobile: "true",
            locale: "{{ app()->getLocale() }}",
        });

        flatpickr("#date_of_supply", {
            disableMobile: "true",
            locale: "{{ app()->getLocale() }}",
        });


        var loadFiles = function (event) {
            var images = document.getElementById("change-profile");
            images.src = URL.createObjectURL(event.target.files[0]);
            images.classList.add('img-new-style')
        };

        $(document).on('change', '#category_type', function (){
            activeSubstances($(this))
        });

        function activeSubstances(el){
            if($(el).val() == 'medicine'){
                $('.activeSubstances').removeClass('hidden')
            }else {
                $('.activeSubstances').addClass('hidden')
            }
        }

        activeSubstances($('#category_type'));
    </script>

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
    @include('providers_dashboards.store.includes.js.formAjax')

@endpush
