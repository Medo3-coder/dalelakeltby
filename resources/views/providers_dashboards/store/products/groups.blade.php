@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/select2.css" />

@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>اضافة منتج جديد</h6>
                <div class="links-top-to">
                    <a href="{{ route('store.products') }}">{{ __('store.products') }}</a>  /
                    <span class="color-main">{{ __('store.add_groups', ['name'=>$product->name]) }}</span>
                </div>
            </div>
                <div class="card-ins">
                    <div class="card-white putin-me">
                        <h4 class="font_bold mb-4 spe-border">{{ __('store.Product attribute data', ['name'=>$product->name]) }}</h4>
                        <div class="grid-cart col-lg-8 col-12 grid-defi">
                            @foreach($productFeatures as $pf)
                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ $pf->feature->name }}</h6>
                                    <select name="productfeatures_ids[]" id="" class="default2-select gr my-spe-sele">
                                        @foreach($pf->productfeatureproperities as $pfp)
                                        <option value="{{ $pfp->properity->id }}">{{ $pfp->properity->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach

                            <input type="text" class="good-spe" value="" hidden>
                            <button class="add-defi" type="button" onclick="addProductAttribute()"><i class="fa-solid fa-plus"></i></button>
                        </div>

                        @foreach ($product->groups->where('properities' , '!=' , null) as $group)
                            <div class="plus-defi">
                            <form action="{{ route('store.products.groups.update', $product['id']) }}" class="form" method="POST" enctype="multipart/form-data" id="form">
                                @csrf
                                <?php
                                    $string = '';
                                    foreach ($group->properities_data as $key => $prop){
                                        $string .= $key != count($group->properities_data) - 1 ? $prop->name . ' + ' : $prop->name  ;
                                    }
                                    ?>

                                <div class="flex-identfy">
                                    <div class=" mb-4 font_bold top-identfy">{{ $string }}</div>
                                    <input type="hidden" name="ids" class="main_div" value="{{ $group->properities }}">
                                    <input type="hidden" name="product_id" class="main_div" value="{{ $product['id'] }}">
                                    <input type="hidden" name="group_id" class="main_div group_id" value="{{ $group->id }}">
                                    <div class="remove-identfy" onclick="removeElement(this)"><i class="fa-solid fa-xmark"></i></div>
                                </div>
                                <div class="col-12 col-lg-8 flex-add-new mb-4">
                                    <div class="right-go-up">
                                        <img id="" class="img-new-style"  src="{{ $group->image }}" alt="">
                                        <input type="file"   onchange="uploadProfileIMG(this)"    class="upload-ff" name="image" hidden>
                                        <label onclick="$(this).parent().find('.upload-ff').click()" class="new-product-upload-spe">
                                            <i class="fa-solid fa-camera"></i>
                                        </label>
                                    </div>
                                    <div class="left-go-up">
                                        <div class="font_bold">{{ __('store.group photo') }}</div>
                                        <div class="text-secondary"></div>
                                    </div>

                                </div>
                                <div class="error_show error_image"> </div>
                                <div class="grid-cart col-lg-8 col-12">
                                    <div class="mb-3 main-inp-cont">
                                        <h6 class="fontBold mainColor font14">{{ __('store.price') }}</h6>
                                        <div class="form__label">
                                            <input
                                                    class="default_input"
                                                    type="number"
                                                    name="price"
                                                    step=".01"
                                                    value="{{ $product->groupOne()->price }}"
                                                    placeholder="{{ __('store.Please enter the price') }}"
                                            />
                                            <label class="float__label" for=""
                                            >{{ __('store.Please enter the price') }}</label
                                            >

                                        </div>
                                        <div class="error_show error_price"> </div>
                                    </div>
                                    <div class="mb-3 main-inp-cont">
                                        <h6 class="fontBold mainColor font14">{{ __('store.quantity in stock') }}</h6>
                                        <div class="form__label">
                                            <input
                                                    class="default_input"
                                                    type="number"
                                                    name="in_stock_qty"
                                                    step=".01"
                                                    value="{{ $product->groupOne()->in_stock_qty }}"
                                                    placeholder="{{ __('store.Please enter the quantity') }}"
                                            />
                                            <label class="float__label" for=""
                                            >{{ __('store.Please enter the quantity') }}</label
                                            >

                                        </div>
                                        <div class="error_show error_in_stock_qty"> </div>
                                    </div>
                                </div>
                                <div class="mb-3 main-inp-cont col-12 col-lg-8">
                                    <h6 class="fontBold mainColor font14">{{ __('store.The price after discount') }}</h6>
                                    <div class="form__label">
                                        <input
                                                class="default_input"
                                                type="number"
                                                step=".01"
                                                name="discount_price"
                                                value="{{ $product->groupOne()->discount_price }}"
                                                placeholder="{{ __('store.Please enter the price after discount') }}"
                                        />
                                        <label class="float__label" for=""
                                        >{{ __('store.Please enter the price after discount') }}</label
                                        >

                                    </div>
                                    <div class="error_show error_discount_price"> </div>
                                </div>
                                <div class="grid-cart col-lg-8 col-12">
                                    @foreach (languages() as $lang)
                                        <div class="mt-3 main-inp-cont">
                                            <h6 class="fontBold mainColor mb-1 font14">{{ __('store.desc_groups_' . $lang) }}</h6>
                                            <label class="form__label">
                                  <textarea
                                          class="default_input"
                                          type="text"
                                          name="desc[{{ $lang }}]"
                                          placeholder="{{ __('store.choose_desc_groups_' . $lang) }}"
                                  >{{ $group->getTranslation('desc', $lang) }}</textarea>
                                                <span class="float__label">{{ __('store.choose_desc_groups_' . $lang) }} </span>
                                            </label>
                                            <div class="error_show error_desc[{{ $lang }}]"> </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-12">
                                    <button class="submit up mt-3 mr-2 text-center submit-button" id="submit-button" type="submit">{{ __('store.Modify the group') }}</button>
                                </div>
                            </form>
                        </div>
                        @endforeach


                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <a class="submit up mt-3 mr-2 text-center" id="finish-product"  href="{{ route('store.products') }}">{{ __('store.finish product') }}</a>
                    </div>
                </div>

        </div>

    </main>


@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>
    <script src="{{ asset('/') }}dashboard/js/select2.js"></script>
    <script>

        $('#finish-product').on('click', function (){
            event.preventDefault();
            var groupId = $('.group_id');
            var groupEmpty = groupId.filter(function() { return $(this).val() == ""; }).length;
            var url = $(this).attr('href');
            if (groupId.length > groupEmpty){
                Swal.fire({
                    icon: 'success',
                    iconColor: '#2f71b3',
                    title: '<h5 class="font_bold">'+ '{{ __('store.The product has been completed successfully') }}' +'</h5>',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('store.ok') }}',
                    timer: 2000
                });

                setTimeout(function(){
                    window.location.replace(url)
                }, 1000);
            }else {
                Swal.fire({
                    icon: 'error',
                    iconColor: '#ff0000',
                    title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, you must create at least one group') }}' +'</h5>',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('store.ok') }}',
                    timer: 2000
                })
            }
        });

        function uploadProfileIMG (input){


            input.previousElementSibling.src = URL.createObjectURL(event.target.files[0]);

            input.previousElementSibling.classList.add('img-new-style');


        }


        let selects = document.querySelectorAll('.my-spe-sele');

        const myhidden = document.querySelector('.good-spe');
        function addProductAttribute(){
            const fruits = [];
            const ids = [];

            for(let i = 0 ; i < selects.length ; i++){

                let values = selects[i].options[selects[i].selectedIndex].innerHTML
                let values2 = selects[i].options[selects[i].selectedIndex].value
                ids.push(values2);
                fruits.push(values);
                ourVal = fruits.join(' + ');
                myhidden.value = ourVal
            }




            $(".top-identfy").each(function () {
                if(myhidden.value === $(this).html().trim() ){
                    Swal.fire({
                        icon: 'info',
                        iconColor: '#2f71b3',
                        title: '<h5 class="font_bold">'+ '{{ __('store.This group has already been added') }}' +'</h5>',
                        showConfirmButton: true,
                        confirmButtonText: '{{ __('store.ok') }}',
                        timer: 3000
                    })
                    document.querySelector('.add-defi').setAttribute('disabled')


                }
            });

            var idsString = ids.join(',');





            let addDetails2 = `

      <div class="plus-defi">
 <form action="{{ route('store.products.groups.update', $product['id']) }}" class="form" method="POST" enctype="multipart/form-data" id="form">
 @csrf
            <div class="flex-identfy">
             <div class=" mb-4 font_bold top-identfy">${ myhidden.value}</div>
             <input type="hidden" class="top-identfy-input" value="${myhidden.value}">
        <input id="[${idsString}]" type="hidden" name="ids" class="main_div" value="[${idsString}]">
        <input type="hidden" name="product_id" class="main_div" value="{{ $product['id'] }}">
        <input type="hidden" name="group_id" class="main_div group_id" value="">
        <div class="remove-identfy" onclick="removeElement(this)"><i class="fa-solid fa-xmark"></i></div>
        </div>
                        <div class="col-12 col-lg-8 flex-add-new mb-4">
                            <div class="right-go-up">
                                <img id="${'change-profile'}" src="{{ asset('/') }}dashboard/imgs/Group 46059.png" alt="">
                            <input type="file"   onchange="uploadProfileIMG(this)"    class="upload-ff" name="image" hidden>
                                        <label onclick="$(this).parent().find('.upload-ff').click()" class="new-product-upload-spe">
                                    <i class="fa-solid fa-camera"></i>
                                </label>
                            </div>
                            <div class="left-go-up">
                                <div class="font_bold">{{ __('store.group photo') }}</div>
                                <div class="text-secondary"></div>
                            </div>

                        </div>
                        <div class="error_show error_image"> </div>
                        <div class="grid-cart col-lg-8 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.price') }}</h6>
                                <div class="form__label">
                                  <input
                                    class="default_input"
                                    type="number"
                                    name="price"
                                    step=".01"
                                    value="{{ $product->groupOne()->price }}"
                                    placeholder="{{ __('store.Please enter the price') }}"
                                  />
                                  <label class="float__label" for=""
                                    >{{ __('store.Please enter the price') }}</label
                                  >

                                </div>
                                <div class="error_show error_price"> </div>
                            </div>
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.quantity in stock') }}</h6>
                                <div class="form__label">
                                  <input
                                    class="default_input"
                                    type="number"
                                    name="in_stock_qty"
                                    step=".01"
                                    value="{{ $product->groupOne()->in_stock_qty }}"
                                    placeholder="{{ __('store.Please enter the quantity') }}"
                                  />
                                  <label class="float__label" for=""
                                    >{{ __('store.Please enter the quantity') }}</label
                                  >

                                </div>
                                <div class="error_show error_in_stock_qty"> </div>
                            </div>
                        </div>
                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.The price after discount') }}</h6>
                            <div class="form__label">
                              <input
                                class="default_input"
                                type="number"
                                step=".01"
                                name="discount_price"
                                value="{{ $product->groupOne()->discount_price }}"
                                placeholder="{{ __('store.Please enter the price after discount') }}"
                              />
                              <label class="float__label" for=""
                                >{{ __('store.Please enter the price after discount') }}</label
                              >

                            </div>
                            <div class="error_show error_discount_price"> </div>
                        </div>
                        <div class="grid-cart col-lg-8 col-12">
                        @foreach (languages() as $lang)
            <div class="mt-3 main-inp-cont">
                <h6 class="fontBold mainColor mb-1 font14">{{ __('store.desc_groups_' . $lang) }}</h6>
                                <label class="form__label">
                                  <textarea
                                    class="default_input"
                                    type="text"
                                    name="desc[{{ $lang }}]"
                                    placeholder="{{ __('store.choose_desc_groups_' . $lang) }}"
                                  ></textarea>
                                  <span class="float__label">{{ __('store.choose_desc_groups_' . $lang) }} </span>
                                </label>
                                <div class="error_show error_desc[{{ $lang }}]"> </div>
                            </div>
                        @endforeach
            </div>
<div class="col-12">
<button class="submit up mt-3 mr-2 text-center submit-button" id="submit-button" type="submit">{{ __('store.Create the group') }}</button>
</div>
</form>
                    </div>

      `



            $('.putin-me').append(addDetails2);
            window.scrollTo({ left: 0, top: document.body.scrollHeight  , behavior: "smooth" });
        }

        function removeElement(rmButton){
            var id = $(rmButton).parent().find('.group_id').val();
            if(id == ''){
                $(rmButton).closest('.plus-defi').remove();
                Swal.fire({
                    icon: 'success',
                    iconColor: '#2f71b3',
                    title: '<h5 class="font_bold">'+ '{{ __('store.The group has been successfully deleted') }}' +'</h5>',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('store.ok') }}',
                    timer: 2000
                })
            }else {
                $.ajax({
                    url: '{{ route('store.products.groups.delete', $product['id']) }}',
                    method: 'post',
                    data: {
                        _token:'{{ csrf_token() }}',
                        _method:'DELETE',
                        id:id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $(rmButton).closest('.plus-defi').remove();
                        Swal.fire({
                            icon: 'success',
                            iconColor: '#2f71b3',
                            title: '<h5 class="font_bold">'+ '{{ __('store.The group has been successfully deleted') }}' +'</h5>',
                            showConfirmButton: true,
                            confirmButtonText: '{{ __('store.ok') }}',
                            timer: 2000
                        })

                    },error: function (xhr){
                        Swal.fire({
                            icon: 'error',
                            iconColor: '#ff0000',
                            title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong') }}' +'</h5>',
                            showConfirmButton: true,
                            confirmButtonText: '{{ __('store.ok') }}',
                            timer: 2000
                        })

                    }
                });
            }

        }




    </script>


    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css')}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', '.form', function() {
                event.preventDefault();

                var form = $(this);

                var old_content =  $(this).find(".submit-button").html();

                var url = $(this).attr('action')
                $(this).ajaxSubmit({
                    url: url,
                    beforeSend: function () {
                        old_content = form.find(".submit-button").html();
                        var submitForm =  $(this).find('.submit-button');
                        submitForm.attr('disabled', true)
                    },
                    uploadProgress:function (event,position,total,percentComplete) {
                        form.find(".submit-button").text(percentComplete+'%');
                    },
                    success: (response) => {
                        form.find('.error_show').html('');
                        form.find('.text-danger').remove();
                        form.find('input').removeClass('border-danger');
                        form.find('select').removeClass('border-danger');
                        form.find('textarea').removeClass('border-danger');
                        form.find(".submit-button").html(old_content).attr('disabled', false)
                        if (response.status != 'success') {
                            if (response.hasOwnProperty('input')) {
                                form.find('.error_' + response.input).
                                form.find('.error_' + response.input).append(`<span class="mt-5 text-danger">${response.msg}</span>`);
                                $('.form input[name^=' + response.input + ']' + '.form select[name^=' + response.input + ']' + '.form textarea[name^=' + response.input + ']').addClass('border-danger')
                            } else {
                                toastr.error(response.msg)
                            }
                        } else {
                            form.find('input[name="image"]').val('')
                            Swal.fire({
                                icon: 'success',
                                iconColor: '#2f71b3',
                                title: '<h5 class="font_bold">'+ response.msg +'</h5>',
                                showConfirmButton: false,
                                timer: 2000
                            })

                            form.find('.group_id').val(response.id);
                            form.find('.submit-button').text('{{ __('store.Modify the group') }}');
                        }

                        if (response.hasOwnProperty('url')) {
                            setTimeout(function () {
                                window.location.replace(response.url)
                            }, 4000);
                        }
                    },
                    error: function (xhr) {
                        form.find('.text-danger').remove();
                        form.find('.error_show').html('');
                        form.find('input').removeClass('border-danger');
                        form.find('select').removeClass('border-danger');
                        form.find('textarea').removeClass('border-danger');
                        form.find(".submit-button").html(old_content).attr('disabled', false)

                        $.each(xhr.responseJSON.errors, function (key, value) {
                            form.find('[data-name="' + key + '"]').append(`<span class="text-danger d-block">${value}</span>`);
                            if (key.indexOf(".") >= 0) {
                                var split = key.split('.')
                                key = split[0] + '\\[' + split[1] + '\\]'
                            }

                            form.find('.error_' + key).append(`<span class="text-danger d-block">${value}</span>`);
                            form.find('[name^=' + key + ']').addClass('border-danger')

                        });
                    },
                });


            });
        });

    </script>
    <script src="{{asset('admin/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>




@endpush
