@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/select2.css" />
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/jquery.fancybox.min.css" />
@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <form action="{{ route('store.offers.update', $offer['id']) }}" enctype="multipart/form-data" method="POST" class="form" id="form">
                @csrf
                @method('PUT')
                <div class="card-ins">
                    <div class="card-white">
                        <h4 class="font_bold mb-4 no-border-bottom">{{ __('store.Add a new offer') }}</h4>
                        <div class="mff-auto">
                            <div class="grid-cart col-lg-9 col-12">
                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">
                                        {{ __('store.offer_image') }}
                                    </h6>
                                    <div class="form__label">
                                        <label
                                                for="filesNext4_input"
                                                class="apload-img-reg"
                                        >
                                            <input
                                                    type="file"
                                                    hidden
                                                    data-single="true"
                                                    id="filesNext4_input"
                                                    class="heddenUploud files-input"
                                                    name="image"
                                                    data-input="filesNext4"
                                                    accept="image/*"
                                            />
                                            <div class="add-photo">
                                                <i class="fa-solid fa-images"></i>
                                            </div>
                                            <div class="img-apload-title">
                                                {{ __('store.Please enter display image') }}
                                            </div>
                                        </label>
                                    </div>
                                    <div class="error_show error_image"> </div>
                                    <div
                                            class="uploaded__area"
                                            id="filesNext4_cont"
                                    >
                                        <div class="file_">
                                            <a data-fancybox="gallery" href="{{ $offer->image }}">
                                                <img src="{{ $offer->image }}" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @foreach(languages() as $lang)
                                    <div class="mb-3 main-inp-cont">
                                        <h6 class="fontBold mainColor font14">{{ __('store.offer_name_' . $lang) }}</h6>
                                        <div class="form__label">
                                            <input
                                                    class="default_input"
                                                    type="text"
                                                    value="{{ $offer->getTranslation('name', $lang) }}"
                                                    name="name[{{ $lang }}]"
                                                    placeholder="{{ __('store.write') . ' ' . __('store.offer_name_' . $lang) }}"
                                            />
                                            <label class="float__label" for=""
                                            >{{ __('store.write') . ' ' . __('store.offer_name_' . $lang) }}</label
                                            >
                                        </div>
                                        <div class="error_show error_name[{{ $lang }}]"> </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="input_select col-12 col-lg-9  mb-3  main-inp-cont">
                                <h6 class="fontBold mainColor font14 no-border-bottom">{{ __('store.products') }}</h6>
                                <select name="product_id[]" class="select2 multiple_select" multiple="multiple">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                <div class="error_show error_product_id"> </div>
                                <div class="error_show error_product_id[]"> </div>
                            </div>
                            <div class="grid-cart col-lg-9 col-12">
                                <div class="mb-3 main-inp-conts">
                                    <h6 class="fontBold mainColor font14 no-border-bottom p-0">{{ __('store.offer price') }}</h6>
                                    <div class="form__label">
                                        <input
                                                class="default_input"
                                                type="number"
                                                step="0.1"
                                                name="offer_price"
                                                value="{{ $offer->offer_price }}"
                                                placeholder="{{ __('store.offer price val') }}"
                                        />
                                        <label class="float__label" for=""
                                        >{{ __('store.offer price val') }}</label
                                        >
                                    </div>
                                    <div class="error_show error_offer_price"> </div>
                                </div>
                                <div class="mb-3 main-inp-conts">
                                    <h6 class="fontBold mainColor font14 no-border-bottom p-0">{{ __('store.discount') }}</h6>
                                    <div class="form__label">
                                        <input
                                                class="default_input"
                                                type="number"
                                                step="0.1"
                                                name="offer_discount"
                                                value="{{ $offer->offer_discount }}"
                                                placeholder="{{ __('store.write') . ' ' . __('store.discount') }}"
                                        />
                                        <label class="float__label" for=""
                                        >{{ __('store.write') . ' ' . __('store.discount') }}</label
                                        >
                                    </div>
                                    <div class="error_show error_offer_discount"> </div>
                                </div>
                                <div class="mb-3 main-inp-conts">
                                    <h6 class="fontBold mainColor font14 no-border-bottom p-0">{{ __('store.bonus') }}</h6>
                                    <div class="form__label">
                                        <input
                                                class="default_input"
                                                type="number"
                                                name="bonus"
                                                step="0.1"
                                                value="{{ $offer->bonus }}"
                                                placeholder="{{ __('store.write') . ' ' . __('store.bonus') }}"
                                        />
                                        <label class="float__label" for=""
                                        >{{ __('store.write') . ' ' . __('store.bonus') }}</label
                                        >
                                    </div>
                                    <div class="error_show error_bonus"> </div>
                                </div>
                                <div class="mb-3 main-inp-conts">
                                    <h6 class="fontBold mainColor font14 no-border-bottom p-0">{{ __('store.end_offer') }}</h6>
                                    <div class="form__label">
                                        <input
                                                class="default_input flatpickr"
                                                type="datetime-local"
                                                name="end_offer"
                                                id="end_offer"
                                                placeholder="{{ __('store.choose') . ' ' . __('store.end_offer') }}"
                                                value="{{ $offer->end_offer }}"
                                                data-enabletime=true
                                        />
                                        <label class="float__label" for=""
                                        >{{ __('store.choose') . ' ' . __('store.end_offer') }}</label
                                        >
                                    </div>
                                    <div class="error_show error_end_offer"> </div>
                                </div>
                                <div class="mb-3 main-inp-conts">
                                    <h6 class="fontBold mainColor font14 no-border-bottom p-0">{{ __('store.offer_type') }}</h6>
                                    <div class="form__label">
                                        <select name="type" id="" class="default_input">
                                            <option value="products" {{ $offer->type == 'products' ? 'selected' : '' }}>{{ __('store.products') }}</option>
                                            <option value="equipment" {{ $offer->type == 'equipment' ? 'selected' : '' }}>{{ __('store.equipment') }}</option>
                                        </select>
                                        <label class="float__label" for=""
                                        >{{ __('store.choose') . ' ' . __('store.offer_type') }}</label
                                        >
                                    </div>
                                    <div class="error_show error_type"> </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit"  class="submit up wid-60 mt-3 submit-button">{{ __('store.Save the offer') }}</button>

                    </div>
                </div>
            </form>
        </div>
    </main>

@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>

    <script src="{{ asset('/') }}dashboard/js/select2.js"></script>
    <script src="{{ asset('/') }}dashboard/js/jquery.fancybox.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#end_offer", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });

        let select2s = document.querySelector(".select2");
        if (select2s) {
            $(document).ready(function () {

                var select2 = $(".select2")

                select2.val({{ $ids }});
                select2.trigger("change");

                select2.select2({

                    placeholder: {
                        id: '-1',
                        text: '{{ __('store.choose') . ' ' . __('store.products') }}'
                    }
                });
            });
        }
    </script>
    <script>
        let inputsFiles = {};
        $(".files-input").on("change", function (event) {
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
