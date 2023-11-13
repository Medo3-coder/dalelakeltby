@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <style>

    .farouk {
            background: #7367f0;
            border-radius: 5px;
            padding: 12px;
            margin: auto;
            width: 100px;

        }
        .clickAdd {
            display: inline-block;
            width: 140px;
            height: 140px;
            line-height: 110px;
            text-align: center;
            position: relative;
            border-radius: 15px;
            margin: 5px;
            border: 3px dotted #e4e4e4;
            width: 140px;
            height: 140px;
            margin: 20px;
            border-radius: 28px;
        }
        .add-time{
            float: left !important;
        }
    </style>
@endsection
{{-- extra css files --}}

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.add') . ' ' . __('admin.pharmacies') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.pharmacyBranch.store') }}"
                                class="store form-horizontal" novalidate>
                                @csrf

                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <input type="hidden" name="pharmacist_id" value="{{ $id }}">



                                                <div class="col-12">
                                                    <div class="imgMontg col-12 text-center">
        
                                                        <div class="dropBox d-flex">
                                                            <div class="textCenter">
                                                                <div class="imagesUploadBlock">
                                                                    <label class="uploadImg">
                                                                        <span><i class="feather icon-image"></i></span>
                                                                        <input type="file" accept="image/*" name="images[]"
                                                                            class="imageUploader">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
        
                                                        <button class="clickAdd">
                                                            <span>
                                                                <i class="feather icon-plus"></i>
                                                            </span>
                                                        </button>
        
                                                    </div>
                                                    <div class="text-center mb-3">
                                                        <small>{{ __('admin.add_phramces_image') }}<span
                                                                class="text-success"></span></small>
                                                    </div>
                                                </div>
                                         


                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-column">{{ __('admin.name') }}</label>
                                                        <div class="controls">
                                                            <input type="text" name="name" class="form-control"
                                                                placeholder="{{ __('admin.name') }}" required
                                                                data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-column">{{ __('admin.address') }}</label>
                                                        <div class="controls">
                                                            <input id="address" type="text" name="address"
                                                                class="form-control" placeholder="{{ __('admin.address') }}"
                                                                required
                                                                data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label
                                                            for="first-name-column">{{ __('admin.comerical_record') }}</label>
                                                        <div class="controls">
                                                            <input type="number" name="comerical_record"
                                                                class="form-control"
                                                                placeholder="{{ __('admin.comerical_record') }}" required
                                                                data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class=" m-auto round10 col-12 pl-4 pr-4 form-cont">
                                                    <div class="">
                                                        <h6 class="bold farouk">
                                                            {{ __('admin.timings') }}</h6>

                                                        <div class="time-slider-cont ">
                                                            <div class=" w-100 time-button text-center">
                                                                <p class="text-danger">{{ __('admin.time_rule') }} </p>
                                                            </div>
                                                            <div class=" w-100 time-cont pt-3">

                                                                <div class="times-cont" id="clone_div">
                                                                    <div class="container time m-auto">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-md  p-1">
                                                                                <label class="bold">{{ __('admin.day') }}
                                                                                </label>


                                                                                <select name="days[]" id="" class="form-control border no-arrow days_select days_select_each">
                                                                                    <option disabled selected value=>{{__('admin.select_day')}}</option>
                                                                                    <option value="saturday">
                                                                                        {{ __('admin.saturday') }}</option>
                                                                                    <option value="sunday">
                                                                                        {{ __('admin.sunday') }}</option>
                                                                                    <option value="monday">
                                                                                        {{ __('admin.monday') }}</option>
                                                                                    <option value="tuesday">
                                                                                        {{ __('admin.tuesday') }}</option>
                                                                                    <option value="wednesday">
                                                                                        {{ __('admin.wednesday') }}
                                                                                    </option>
                                                                                    <option value="thursday">
                                                                                        {{ __('admin.thursday') }}
                                                                                    </option>
                                                                                    <option value="friday">
                                                                                        {{ __('admin.friday') }}</option>
                                                                                </select>






                                                                            </div>

                                                                            <div class="col-md  p-1 ">
                                                                                <label
                                                                                    class="bold">{{ __('admin.from') }}
                                                                                </label>
                                                                                <input type="time"
                                                                                    class="form-control  border round5 w-100"
                                                                                    name="from[]" id="">
                                                                            </div>

                                                                            <div class="col-md  p-1">
                                                                                <label
                                                                                    class="bold">{{ __('admin.to') }}</label>
                                                                                <input type="time"
                                                                                    class="form-control  border round5 w-100"
                                                                                    name="to[]" id="">
                                                                            </div>


                                                                            <div class="col-md-1  p-1">
                                                                                <div
                                                                                    class="d-flex align-items-center flex-column">
                                                                                    <label class="bold sn"
                                                                                        style="color: #fff;"></label>
                                                                                    <a type="button"
                                                                                        class="button-error material-button"
                                                                                        onclick="removeTime(this)"><i
                                                                                            class="fa fa-times"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <a class="m-3 btn btn-primary add-time float-left"><i class="fa fa-plus">{{ __('admin.Add_time') }}</i></a>
                                                </div>

                                            
                                                



                                                <div class="col-md-12 col-12 ">
                                                    <div class="form-group  pl-5 pr-5 mt-4 position-relative">
                                                        <label for=""
                                                            class="d-block mb-3 siz13 font-weight-bolder">{{ awtTrans('تحديد الموقع') }}</label>
                                                        <div class="controls">
                                                            {{-- <input  class="form-control position-absolute w-25" style="z-index: 11111; top:14%; left:7%" id="searchTextField" value="" placeholder="{{awtTrans('تحديد موقعك')}}"> --}}
                                                        </div>
                                                        <div id="map" style="height: 400px; margin-top: 20px">
                                                        </div>
                                                        <input type="hidden" id="lat" name="lat"
                                                            value="">
                                                        <input type="hidden" id="lng" name="lng"
                                                            value="">
                                                    </div>
                                                </div>






                                                <div class="col-12 d-flex justify-content-center mt-3">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.add') }}</button>
                                                    <a href="{{ url()->previous() }}" type="reset"
                                                        class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>

    {{-- show selected image script --}}
    @include('admin.shared.addImage')
    {{-- show selected image script --}}

    {{-- submit add form script --}}
    @include('admin.shared.submitAddForm')
    {{-- submit add form script --}}


 



<script>
    // function addTime() {
    $(document).on('click' , '.add-time', function() {

        var clone_div = $('#clone_div').clone();
        clone_div.find('input').val(null);
        $('.time-cont').append(clone_div);
    })

    $(document).on('change' , '.days_select', function() {
        var value = $(this).val()
        var current_select = $(this)
        current_select.removeClass('days_select_each')
        $( ".days_select_each" ).each(function( i ) {
            if ($(this).val() == value) {
                toastr.error("{!! __('admin.used_before') !!}");
                current_select.val(null)
               

            }
        });
        current_select.addClass('days_select_each')
    });

    function removeTime(rmButton) {
        $(rmButton).parents(".times-cont").remove();
    }

</script>

    {{-- #Maps --}}
    @include('admin.partials.map')
@endsection
