@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/select2.css" />
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/jquery.fancybox.min.css" />


@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">
                    <h6>{{ __('store.display name') . ' : ' . $offer->name }}</h6>
                </div>
                <a class="test-result no-hover test-btn" href="{{ route('store.offers.edit', $offer->id) }}">
                    <img src="{{ asset('/') }}dashboard/imgs/Group 83036.png" class="img-edit-wid" alt="">
                    {{ __('store.Display adjustment') }}
                </a>
            </div>
            <div class="card-white spe-pad">
                <div class="card-top mt-4">
                    <h5 class="card-top-right font_bold">{{ __('store.Offer details') }}</h5>
                    <div class="card-top-left">
                        <div class="quentity"> {{ __('store.The number of items available') }} : <span>{{ count($products) . '' }}</span></div>
                        <div class="quentity">{{ __('store.offer price') }} : <span>{{ $offer->offer_price. ' ' . __('store.Dinar') }}</span></div>
                        <div class="quentity">{{ __('store.Discount') }} : <span>{{ $offer->offer_discount. ' ' . __('store.Dinar') }}</span></div>
                    </div>
                </div>

                @forelse($products as $product)
                    <div class="box-for-product mb-3">
                        <div class="box-for-product-right">
                            <a href="{{ route('store.offers.product.show', $product['id']) }}">
                                <img
                                        src="{{ $product->image }}"
                                        alt=""
                                />
                            </a>
                        </div>
                        <div class="box-for-product-left">
                            <div class="box-for-product-left-f-top mb-3">
                                <h6 class="font-bold no-border-bottom padding-btm-no">
                                    {{ $product->name }}
                                </h6>
                                <div class="center-flex">
                                    <div class="line-spe-div">{{ __('store.incoming quantity') . ' : ' . $product->groupOne()->in_stock_qty . ' ' . __('store.Package') }}</div>
                                    <div class="line-spe-div">{{ __('store.price') . ' : '  }} {!! $product->display_price() !!}</div>
                                </div>

                            </div>
                            <div class="par-code">{{ $product->product_num }}</div>
                            @if($product->category_type == 'medicine')
                                <div class="all-spans">
                                    <span>{{ __('store.Active substances') }} : </span>
                                    <span>{{ $product->effective_material }}</span>
                                </div>
                            @endif
                            <div class="decive-job">
                                <span class="hegh-span"> {{ $product->category_type == 'medicine' ? __('store.medicine description') : __('store.Device description') }} : </span>
                                <p class="color-gray">
                                    {{ $product->desc }}
                                </p>
                            </div>
                            <div class="box-for-product-left-rr">
                                <div class="line-spe-div">  {{ __('store.date of supply') }} : {{ Carbon\Carbon::parse($product->date_of_supply)->translatedFormat('j F Y') }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
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
                $(".select2").select2({
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
