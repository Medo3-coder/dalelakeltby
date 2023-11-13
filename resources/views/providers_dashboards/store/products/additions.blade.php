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
                    <span class="color-main">{{ __('store.Product additions', ['name'=>$product->name]) }}</span>
                </div>
            </div>
            <form action="{{ route('store.products.additionsUpdate', $product->id) }}" method="POST" class="form">
                @csrf
                <div class="card-ins">
                    <div class="card-white dafult-card-spe">
                        <h4 class="font_bold mb-4 spe-border">{{ __('store.Addition data') }}</h4>
                        <div class="">
                            <div class="grid-cart col-lg-8 col-12 ">
                                <div class="add-defi" onclick="proaddition()"><i class="fa-solid fa-plus"></i></div>
                            </div>
                            @foreach($product->additives as $key => $additive)
                                <div class="show-defi mt-3">
                                    <input type="hidden" name="index" value="{{ $key }}">
                                    <div class="grid-cart col-lg-8 col-12 ">
                                        @foreach(languages() as $lang)
                                            <div class="mb-3 main-inp-cont">
                                                <h6 class="fontBold mainColor font14">{{ __('store.addition_name_' . $lang) }}</h6>
                                                <div class="form__label">
                                                    <input
                                                            class="default_input"
                                                            type="text"
                                                            name="name_{{ $lang }}[{{ $key }}]"
                                                            value="{{ $additive->getTranslation('name', $lang) }}"
                                                            placeholder="{{ __('store.write') . ' ' . __('store.addition_name_' . $lang) }}"
                                                    />
                                                    <label class="float__label" for=""
                                                    >{{ __('store.write') . ' ' . __('store.addition_name_' . $lang) }}</label
                                                    >
                                                </div>
                                                <div class="error_show error_name_{{ $lang }}[{{ $key }}]"> </div>
                                            </div>
                                        @endforeach

                                        <div class="mb-3 main-inp-cont">
                                            <h6 class="fontBold mainColor font14">{{ __('store.Addition price') }}</h6>
                                            <div class="form__label">
                                                <input
                                                        class="default_input"
                                                        type="number"
                                                        step=".01"
                                                        name="price[{{ $key }}]"
                                                        value="{{ $additive->price }}"
                                                        placeholder="{{ __('store.choose') }} {{ __('store.Addition price') }}"
                                                />
                                                <label class="float__label" for=""
                                                >{{ __('store.write') }} {{ __('store.Addition price') }}</label
                                                >
                                            </div>
                                            <div class="error_show error_price[${counter}]"> </div>
                                        </div>
                                    </div>
                                    <div class="flex-defi2 d-flex align-items-center">

                                        <div class="grid-cart col-lg-8 col-12">

                                            <div class="mb-3 main-inp-cont">
                                                <h6 class="fontBold mainColor font14">{{ __('store.Addition price after discount') }}</h6>
                                                <div class="form__label">
                                                    <input
                                                            class="default_input"
                                                            type="number"
                                                            step=".01"
                                                            name="discount_price[{{ $key }}]"
                                                            value="{{ $additive->discount_price }}"
                                                            placeholder="{{ __('store.write') }} {{ __('store.Addition price after discount') }}"
                                                    />
                                                    <label class="float__label" for=""
                                                    >{{ __('store.write') }} {{ __('store.Addition price after discount') }}</label
                                                    >

                                                </div>
                                                <div class="error_show error_discount_price[${counter}]"> </div>
                                            </div>
                                            <div class="mb-3 main-inp-cont ">
                                                <h6 class="fontBold mainColor font14">{{ __('store.Add section') }}</h6>
                                                <select name="product_additive_category_id[{{ $key }}]" id="" class="default2-select gr">
                                                    <option value="" selected>{{ __('store.choose') }}  {{ __('store.Add section') }}</option>
                                                    @if(count($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ $additive->product_additive_category_id == $category['id'] ? 'selected' : '' }} >{{ $category->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="error_show error_product_additive_category_id[${counter}]"> </div>
                                            </div>
                                        </div>
                                        <div class="remove-defi" onclick="removeElement(this)"><i class="fa fa-minus fa-xmark"></i></div>
                                    </div>


                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="submit up mt-3 mr-2 text-center submit-button">{{ __('store.Save changes') }}</button>
                </div>
            </form>
        </div>


    </main>


@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>
    <script src="{{ asset('/') }}dashboard/js/select2.js"></script>

    <script>
        var loadFiles = function (event) {
            var images = document.getElementById("change-profile");
            images.src = URL.createObjectURL(event.target.files[0]);
            images.classList.add('img-new-style')
        };


        function proaddition(){
            var counter = $('input[name="index"]').length;

            counter++

            let additionSpe = `
        <div class="show-defi mt-3">
        <input type="hidden" name="index" value="${counter}">
<div class="grid-cart col-lg-8 col-12 ">
                                @foreach(languages() as $lang)
            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">{{ __('store.addition_name_' . $lang) }}</h6>
                                        <div class="form__label">
                                            <input
                                                    class="default_input"
                                                    type="text"
                                                    name="name_{{ $lang }}[${counter}]"
                                                    placeholder="{{ __('store.write') . ' ' . __('store.addition_name_' . $lang) }}"
                                            />
                                            <label class="float__label" for=""
                                            >{{ __('store.write') . ' ' . __('store.addition_name_' . $lang) }}</label
                                            >
                                        </div>
                                        <div class="error_show error_name_{{ $lang }}[${counter}]"> </div>
                                    </div>
                                @endforeach

            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">{{ __('store.Addition price') }}</h6>
                                        <div class="form__label">
                                            <input
                                                    class="default_input"
                                                    type="number"
                                                    step=".01"
                                                    name="price[${counter}]"
                                                    placeholder="{{ __('store.choose') }} {{ __('store.Addition price') }}"
                                            />
                                            <label class="float__label" for=""
                                            >{{ __('store.write') }} {{ __('store.Addition price') }}</label
                                            >
                                        </div>
                                        <div class="error_show error_price[${counter}]"> </div>
                                    </div>
                            </div>
                            <div class="flex-defi2 d-flex align-items-center">

                                <div class="grid-cart col-lg-8 col-12">

                                    <div class="mb-3 main-inp-cont">
                                        <h6 class="fontBold mainColor font14">{{ __('store.Addition price after discount') }}</h6>
                                        <div class="form__label">
                                            <input
                                                    class="default_input"
                                                    type="number"
                                                    step=".01"
                                                    name="discount_price[${counter}]"
                                                    placeholder="{{ __('store.write') }} {{ __('store.Addition price after discount') }}"
                                            />
                                            <label class="float__label" for=""
                                            >{{ __('store.write') }} {{ __('store.Addition price after discount') }}</label
                                            >

                                        </div>
                                        <div class="error_show error_discount_price[${counter}]"> </div>
                                    </div>
                                    <div class="mb-3 main-inp-cont ">
                                        <h6 class="fontBold mainColor font14">{{ __('store.Add section') }}</h6>
                                        <select name="product_additive_category_id[${counter}]" id="" class="default2-select gr">
                                            <option value="" selected>{{ __('store.choose') }}  {{ __('store.Add section') }}</option>
                                            @if(count($categories) > 0)
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
            @endif
            </select>
            <div class="error_show error_product_additive_category_id[${counter}]"> </div>
                                    </div>
                                </div>
                                <div class="remove-defi" onclick="removeElement(this)"><i class="fa fa-minus fa-xmark"></i></div>
                            </div>


                       </div>
        `
            $('.dafult-card-spe').append(additionSpe);

        }

        function removeElement(rmButton){
            $(rmButton).closest('.show-defi').remove();
            Swal.fire({
                icon: 'success',
                iconColor: '#2f71b3',
                title: '<h5 class="font_bold">'+ '{{ __('store.Please save the changes') }}' +'</h5>',
                showConfirmButton: true,
                confirmButtonText: '{{ __('store.ok') }}',
                timer: 2000
            })
        }
    </script>

    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>

    @include('providers_dashboards.store.includes.js.formAjax')



@endpush
