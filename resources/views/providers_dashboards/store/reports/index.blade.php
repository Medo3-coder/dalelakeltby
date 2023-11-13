@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

@endpush
@section('content')


    <main class="main-sec" id="main">
        <div class="container">

            <div class="side-heading mt-4">
                <h6>{{ $msg }}</h6>
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

                </div>

            </div>

            <div class="overflowx_auto mb-3 table_content_append">

            </div>
        </div>
    </main>


@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>
    <script src="{{asset('admin/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    @include('admin.shared.filter_js' , [ 'index_route' => url('store/reports/orders/' . $status)])


    <script>
        flatpickr("#from", {
            disableMobile: "true",
        });
        flatpickr("#to", {
            disableMobile: "true",
        });

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
                title: '<h5 class="font_bold">'+ "{{ __('store.Do you want to delete the section?') }}" +'</h5>',
                showDenyButton: true,
                showCancelButton: true,
                showConfirmButton: false,
                denyButtonText: '{{ __('store.delete') }}',
                cancelButtonText:'{{ __('store.cancel') }}'
            }).then((result)=>{
                if (result.isDenied) {

                    $(this).ajaxSubmit({
                        url: '{{ route('store.categories.delete') }}',
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
