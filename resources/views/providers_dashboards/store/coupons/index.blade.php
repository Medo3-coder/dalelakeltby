@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

@endpush
@section('content')


    <main class="main-sec" id="main">
        <div class="container">

            <div class="side-heading mt-4">
                <h6>{{ __('store.discount coupons') }}</h6>
                <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('store')->user()->name])</p>
            </div>
            <div class="table-top">
                <div class="select-spe">
                    <div class="select-spe-text">@lang('site.filter_by')</div>
                    <select name="order" class="default-select search-input">
                        <option value>{{ __('admin.choose') }}</option>
                        <option value="ASC">{{ __('admin.Progressive') }}</option>
                        <option value="DESC" selected>{{ __('admin.descending') }}</option>
                    </select>
                </div>

                <div class="select-spe ">
                    <div class="select-spe-text">@lang('site.filter_by_date')</div>
                    <div class="inp-date-con d-flex flex-row">
                        <div class="select-spe-text" style="padding: 10px">@lang('site.from')</div>
                        <input name="created_at_min"  type="datetime-local" id="from"  placeholder="@lang('site.select_date')" class="default-date-inp search-input" />
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <div class="inp-date-con  d-flex flex-row">
                        <div class="select-spe-text" style="padding: 10px">@lang('site.to')</div>
                        <input name="created_at_max"  type="datetime-local" id="to"  placeholder="@lang('site.select_date')" class="default-date-inp search-input" />
                        <i class="fa-regular fa-calendar"></i>
                    </div>
                    <div class="inp-date-con  d-flex flex-row" style="margin-bottom: 16px">
                        <a href="{{ route('store.coupons.create') }}" class="add_new_test up edit-btn-add"><i class="fa-solid fa-plus"></i></a>
                    </div>

                </div>

            </div>

            <div class="overflowx_auto mb-3 table_content_append">

            </div>
        </div>
    </main>

    <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe">
            <div class="modal-content">

                <div class="modal-body no-border-bottom modal1-spe">
                    <h5 class="font-17 font_bold mb-3 ">{{ __('store.edit') . ' ' .__('store.Personal data') }}</h5>
                    <form action="{{ route('store.coupons.changeStatusAvailable') }}" method="POST" enctype="multipart/form-data" class="form">
                        @csrf
                        <input type="hidden" name="id" value="" class="idCoupon">
                        <div class="row">
                            <div class="mb-3 main-inp-cont col-12 col-lg-8">
                                <h6 class="fontBold mainColor font14">{{ __('store.The number of times of use') }}</h6>
                                <div class="form__label">
                                    <input
                                            class="default_input"
                                            type="number"
                                            name="max_use"
                                            placeholder="{{ __('store.Please enter the number of times used') }}"
                                    />
                                    <label class="float__label" for=""
                                    >{{ __('store.Please enter the number of times used') }}</label
                                    >
                                </div>
                                <div class="error_show error_max_use"> </div>
                            </div>

                            <div class="mb-3 main-inp-cont col-12 col-lg-8">
                                <h6 class="fontBold mainColor font14">{{ __('store.discount type') }}</h6>
                                <div class="form__label">
                                    <select name="type" class="default_input" id="">
                                        <option value="ratio">{{ __('store.ratio') }}</option>
                                        <option value="number">{{ __('store.number') }}</option>
                                    </select>
                                    <label class="float__label" for=""
                                    >{{ __('store.Please select a discount type') }}</label
                                    >
                                </div>
                                <div class="error_show error_type"> </div>
                            </div>


                            <div class="mb-3 main-inp-cont col-12 col-lg-8">
                                <h6 class="fontBold mainColor font14">{{ __('store.discount value') }}</h6>
                                <div class="form__label">
                                    <input
                                            class="default_input"
                                            type="number"
                                            name="discount"
                                            step="0.1"
                                            placeholder="{{ __('store.Please enter the discount amount') }}"
                                    />
                                    <label class="float__label" for=""
                                    >{{ __('store.Please enter the discount amount') }}</label
                                    >
                                </div>
                                <div class="error_show error_discount"> </div>
                            </div>

                            <div class="mb-3 main-inp-cont col-12 col-lg-8">
                                <h6 class="fontBold mainColor font14">{{ __('store.The largest value of the discount') }}</h6>
                                <div class="form__label">
                                    <input
                                            class="default_input"
                                            type="number"
                                            name="max_discount"
                                            step="0.1"
                                            placeholder="{{ __('store.Please enter the largest discount value') }}"
                                    />
                                    <label class="float__label" for=""
                                    >{{ __('store.Please enter the largest discount value') }}</label
                                    >
                                </div>
                                <div class="error_show error_max_discount"> </div>
                            </div>

                            <div class="mb-3 main-inp-cont col-12 col-lg-8">
                                <h6 class="fontBold mainColor font14">{{ __('store.Expiry date') }}</h6>
                                <div class="form__label">
                                    <input
                                            class="default_input"
                                            type="date"
                                            name="expire_date"
                                            id="expire_date"
                                            placeholder="{{ __('store.Please enter expiry date') }}"
                                    />
                                    <label class="float__label" for=""
                                    >{{ __('store.Please enter expiry date') }}</label
                                    >
                                </div>
                                <div class="error_show error_expire_date"> </div>
                            </div>



                        </div>

                        <div class="d-flex align-items-center justify-content-center">
                            <button type="submit" class="submit submit-button up mt-3 wid-80-spe">
                                {{ __('store.Save changes') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>
    <script src="{{asset('admin/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/{{ lang() }}.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    @include('admin.shared.filter_js' , [ 'index_route' => url('store/coupons')])
    @include('providers_dashboards.store.includes.js.formAjax')


    <script>
        flatpickr("#from", {
            disableMobile: "true",
        });
        flatpickr("#to", {
            disableMobile: "true",
        });

        flatpickr("#expire_date", {
            disableMobile: "true",
            "locale": "{{ lang() }}"
        });


        $(document).on('click', '.open-coupon',  function (){
            $('.idCoupon').val($(this).data('id'));
        })




        $(document).on('click', '.changeStatusClosed', function (){
            $(this).ajaxSubmit({
                url: '{{ route('store.coupons.changeStatusClosed') }}',
                method:"POST",
                data:{
                    _token:'{{ csrf_token() }}',
                    id:$(this).data('id')
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
        })


        function sm(el) {
            el.parentElement.querySelector('.drop-down').classList.add("show-drop-res");
            document.addEventListener("click", (e) => {
                if (e.target.tagName != "I" || e.target != el) {
                    el.parentElement.querySelector('.drop-down').classList.remove("show-drop-res");
                }
            });
        }

        $(document).on('click', '.delete-row', function (){
            event.preventDefault();
            var deleteProduct = $(this);
            Swal.fire({
                icon: 'info',
                iconColor: '#2f71b3',
                title: '<h5 class="font_bold">'+ "{{ __('store.Do you want to delete the discount coupon?') }}" +'</h5>',
                showDenyButton: true,
                showCancelButton: true,
                showConfirmButton: false,
                denyButtonText: '{{ __('store.delete') }}',
                cancelButtonText:'{{ __('store.cancel') }}'
            }).then((result)=>{
                if (result.isDenied) {

                    $(this).ajaxSubmit({
                        url: '{{ route('store.coupons.delete') }}',
                        method:"POST",
                        data:{
                          _token:'{{ csrf_token() }}',
                          _method:'DELETE',
                          id:deleteProduct.data('val')
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
        });
    </script>
@endpush
