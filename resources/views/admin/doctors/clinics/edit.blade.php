@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <style>
        .uploadedBlock {
            margin: 5px !important;
        }

        .add-time{
            float: left !important;
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

        .delete-image {
            position: absolute;
            z-index: 9999999;
            left: 36%;
            top: 42%;
            background: bottom;
            font-size: 26px;
            border: aquamarine;
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
                        <h4 class="card-title">{{ __('admin.update') . ' ' . __('admin.branch') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.ClinicBranch.updateBranch', ['id' => $row->id]) }}"
                                class="store form-horizontal" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">

                                        <div class="imgMontg col-12 text-center">

                                            <div class="dropBox d-flex">
                                                @foreach ($images as $image)
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*" name="images[]"
                                                                    class="imageUploader">
                                                            </label>
                                                            <div class="uploadedBlock">
                                                                <img src="{{ $image->image }}">
                                                                <button class="delete-image"
                                                                    data-id="{{ $image->id }}"><i
                                                                        class="feather icon-trash text-danger"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <button class="clickAdd">
                                                <span>
                                                    <i class="feather icon-plus"></i>
                                                </span>
                                            </button>


                                        </div>

                                    </div>


                                    <div class="row">

                                        <input type="hidden" name="doctor_id" value="{{ $row->doctor_id }}">



                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.address') }}</label>
                                                <div class="controls">
                                                    <input id="address" type="text" name="address" class="form-control"
                                                        placeholder="{{ __('admin.address') }}" value="{{ $row->address }}"
                                                        required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.comerical_record') }}</label>
                                                <div class="controls">
                                                    <input type="number" name="record_number"
                                                        value="{{ $row->record_number }}" class="form-control"
                                                        placeholder="{{ __('admin.comerical_record') }}" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.detection_price') }}</label>
                                                <div class="controls">
                                                    <input type="number" name="detection_price"
                                                        value="{{ $row->detection_price }}" class="form-control"
                                                        placeholder="{{ __('admin.detection_price') }}" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" m-auto round10 col-12 pl-4 pr-4 form-cont">
                                            <div class="">
                                                <h6 class="bold"
                                                    style="background: #7367f0;
                                                        border-radius: 5px;
                                                        padding: 12px;
                                                        margin: auto;
                                                        width: 100px;
                                                        ">
                                                    {{ __('admin.timings') }}</h6>

                                                <div class="time-slider-cont ">
                                                    <div class=" w-100 time-button text-center">
                                                        <a onclick="addNewTimes()" class="btn mt-1"></a>
                                                        {{-- <h6 class="bold  pt-2 pb-2 ">{{__('admin.no_timings')}} </h6> --}}
                                                        <p style="color: red">{{ __('admin.time_rule') }} </p>
                                                    </div>
                                                    <div class=" w-100 time-cont pt-3">

                                                        @if (count($timings) != 0)
                                                            @foreach ($timings as $timing)
                                                                <div class="times-cont" id="clone_div">
                                                                    <div class="container time m-auto">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-md  p-1">
                                                                                <label class="bold">{{ __('admin.day') }}
                                                                                </label>
                                                                                <select name="days[]" 
                                                                                    class="form-control border no-arrow days_select days_select_each">
                                                                                   {{-- @if ($timing->day == NULL)
                                                                                   <option id="m" disabled selected value=>{{__('admin.select_day')}}</option>
                                                                                      @break
                                                                                   @endif --}}

                                                                                    <option value="saturday" @if($timing->day =='saturday') selected @endif>
                                                                                        {{ __('admin.saturday') }}</option>
                                                                                    <option value="sunday" @if($timing->day =='sunday') selected @endif>
                                                                                        {{ __('admin.sunday') }}</option>
                                                                                    <option value="monday" @if($timing->day =='monday') selected @endif>
                                                                                        {{ __('admin.monday') }}</option>
                                                                                    <option value="tuesday" @if($timing->day =='tuesday') selected @endif>
                                                                                        {{ __('admin.tuesday') }}</option>
                                                                                    <option value="wednesday" @if($timing->day =='wednesday') selected @endif>
                                                                                        {{ __('admin.wednesday') }}
                                                                                    </option>
                                                                                    <option value="thursday" @if($timing->day =='thursday') selected @endif>
                                                                                        {{ __('admin.thursday') }}
                                                                                    </option>
                                                                                    <option value="friday"  @if($timing->day =='friday') selected @endif>
                                                                                        {{ __('admin.friday') }}</option>
                                                                                </select>
                                                                            </div>

                                                                            <div class="col-md  p-1 ">
                                                                                <label
                                                                                    class="bold">{{ __('admin.from') }}
                                                                                </label>
                                                                                <input type="time" required
                                                                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                                                    value="{{ $timing->from }}"
                                                                                    class="form-control  border round5 w-100"
                                                                                    name="from[]" id="">
                                                                            </div>

                                                                            <div class="col-md  p-1">
                                                                                <label
                                                                                    class="bold">{{ __('admin.to') }}</label>
                                                                                <input type="time" required
                                                                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                                                    value="{{ $timing->to }}"
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
                                                            @endforeach
                                                        @else
                                                            <div class="times-cont" id="clone_div">
                                                                <div class="container time m-auto">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md  p-1">
                                                                            <label class="bold">{{ __('admin.day') }}
                                                                            </label>
                                                                            <select name="days[]" required
                                                                                data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                                                class="form-control border no-arrow days_select days_select_each">
                                                                                <option value="saturday">
                                                                                    {{ __('admin.saturday') }}
                                                                                </option>
                                                                                <option value="sunday">
                                                                                    {{ __('admin.sunday') }}
                                                                                </option>
                                                                                <option value="monday">
                                                                                    {{ __('admin.monday') }}
                                                                                </option>
                                                                                <option value="tuesday">
                                                                                    {{ __('admin.tuesday') }}
                                                                                </option>
                                                                                <option value="wednesday">
                                                                                    {{ __('admin.wednesday') }}
                                                                                </option>
                                                                                <option value="thursday">
                                                                                    {{ __('admin.thursday') }}
                                                                                </option>
                                                                                <option value="friday">
                                                                                    {{ __('admin.friday') }}
                                                                                </option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md  p-1 ">
                                                                            <label class="bold">{{ __('admin.from') }}
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
                                                        @endif
                                                    </div>
                                                    {{-- <a class="button1 material-button m-3 btn btn-primary"
                                                                            onclick="addTime()" style="float: left"><i
                                                                                class="fa fa-plus">{{ __('admin.Add_time') }}</i></a> --}}
                                                </div>

                                            </div>
                                            <a class="m-3 btn btn-primary add-time float-left"><i class="fa fa-plus">{{ __('admin.Add_time') }}</i></a>

                                        </div>


                                    </div>
                                    {{-- <a class="button1 material-button m-3 btn btn-primary" onclick="addTime()"
                                        style="float: left"><i class="fa fa-plus">{{ __('admin.Add_time') }}</i></a> --}}
                                </div>

                        </div>
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
                            <input type="hidden" id="lat" name="lat" value="{{ $row->lat }}">
                            <input type="hidden" id="lng" name="lng" value="{{ $row->lng }}">
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-center mt-3">
                        <button type="submit"
                            class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.update') }}</button>
                        <a href="{{ url()->previous() }}" type="reset"
                            class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
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

    {{-- submit edit form script --}}
    @include('admin.shared.submitEditForm')
    {{-- submit edit form script --}}


    <script>
        $(document).on('click', '.delete-image', function(e) {
            e.preventDefault();
            var url = $(this).attr('action')
            $.ajax({
                url: '{{ url('admin/doctors/delete-image/') }}' + '/' + $(this).data('id'),
                method: 'delete',
                data: {},
                dataType: 'json',
                success: (response) => {
                    $(this).parents('.textCenter').remove()
                    Swal.fire({
                        position: 'top-start',
                        type: 'success',
                        title: '{{ awtTrans('تمت حذف الصورة بنجاح') }}',
                        showConfirmButton: false,
                        timer: 1500,
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    })
                },
            });

        });
    </script>


    <script>
        // time
        function addNewTimes() {
            $('.time-button').animate({
                'left': '-200%'
            });
            $('.time-cont').slideDown();
        }


      

        function removeTime(rmButton) {
            $(rmButton).parents(".times-cont").remove();
        }
    </script>


    <script>


        // function addTime() {
        $(document).on('click', '.add-time', function() {

         

            var clone_div = $('#clone_div').clone();
            clone_div.find('input').val(null);
            clone_div.find('select').val(null);
            // $("option[id='1']").remove();
            // $(".days_select_each option:selected").remove();
            $('.time-cont').append(clone_div);
          
            // var ohtml = '';
            // ohtml += ('<option value="1">1</option>');
            // $('#s').empty().append( ohtml );
        })

        $(document).on('change', '.days_select', function() {
            var value = $(this).val()
            var current_select = $(this)
            current_select.removeClass('days_select_each')
            $(".days_select_each").each(function(i) {
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

    @include('admin.partials.map')
@endsection
