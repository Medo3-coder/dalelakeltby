@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" href="{{asset('dist/yearpicker.css')}}">
    
    @endsection
{{-- extra css files --}}

@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('admin.add')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form  method="POST" action="{{route('admin.clients.store')}}" class="store form-horizontal" novalidate>
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="imgMontg col-12 text-center">
                                            <div class="dropBox">
                                                <div class="textCenter">
                                                    <div class="imagesUploadBlock">
                                                        <label class="uploadImg">
                                                            <span><i class="feather icon-image"></i></span>
                                                            <input type="file" accept="image/*" name="image" class="imageUploader">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.name')}}</label>
                                            <div class="controls">
                                                <input type="text" name="name" class="form-control" placeholder="{{__('admin.write_the_name')}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.phone_number')}}</label>
                                            <div class="controls">
                                                <input type="number" name="phone" class="form-control" placeholder="{{__('admin.enter_phone_number')}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}" data-validation-number-message="{{__('admin.the_phone_number_ must_not_have_charachters_or_symbol')}}"  >
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.email')}}</label>
                                            <div class="controls">
                                                <input type="email" name="email" class="form-control" placeholder="{{__('admin.enter_the_email')}}" data-validation-email-message="{{__('admin.email_formula_is_incorrect')}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.password')}}</label>
                                            <div class="controls">
                                                <input type="password" name="password" class="form-control"  required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                            </div>
                                        </div>
                                    </div>




                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.gender')}}</label>
                                            <div class="controls">
                                                <select name="gender" class="select2 form-control" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                                    <option value>{{__('admin.gender')}}</option>
                                                    <option value="male">{{__('admin.male')}}</option>
                                                    <option value="female">{{__('admin.female')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.weight')}}</label>
                                            <div class="controls">
                                                <input type="number" name="weight" class="form-control" placeholder="{{__('admin.enter_the_weight')}}"  required data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.height')}}</label>
                                            <div class="controls">
                                                <input type="number" name="height" class="form-control" placeholder="{{__('admin.write_the_height')}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.bloodtype')}}</label>
                                            <div class="controls">
                                            <select name="blood_type_id" class="select2 form-control" required
                                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                            <option value disabled>{{  __('admin.bloodtype') }}</option>
                                            @foreach ( $bloodTypes as $type )
                                                
                                            <option value="{{ $type->id }}">{{$type->name }}
                                            
                                            @endforeach
                                        </select>
                                            
                                        </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.age')}}</label>
                                            <div class="controls">
                                                <input type="" name="age" class="form-control yearpicker" placeholder="{{__('admin.write_the_date')}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.have_chranic_disease')}}</label>
                                            <div class="controls">
                                                <select  name="has_diseases" class="select2 have_chranic_disease form-control" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                                    <option value>{{__('admin.have_chranic_disease')}}</option>
                                                    <option value="1">{{__('admin.true')}}</option>
                                                    <option value="0">{{__('admin.false')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-6 col-12 selectedInput d-none">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.chranic_disease')}}</label>
                                            <div class="controls">
                                        <select multiple name="chranic_disease_ids[]" class="select2 selectedInputselect form-control" >
                                            <option value disabled>{{  __('admin.chranic_disease') }}</option>
                                            @foreach ( $chranicdiseases as $chranic )
                                                
                                            <option value="{{ $chranic->id }}">{{$chranic->name }}   </option>
                                            
                                            @endforeach
                                        </select>
                                            
                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.Validity')}}</label>
                                            <div class="controls">
                                                <select name="is_blocked" class="select2 form-control" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                                    <option value>{{__('admin.Select_the_blocking_status')}}</option>
                                                    <option value="1">{{__('admin.Prohibited')}}</option>
                                                    <option value="0">{{__('admin.Unspoken')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.add')}}</button>
                                        <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
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
    <script src="{{asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
    <script src="{{asset('admin/app-assets/js/scripts/forms/validation/form-validation.js')}}"></script>
    <script src="{{asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js')}}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
    <script src="{{asset('dist/yearpicker.js')}}"></script>
    
    {{-- show selected image script --}}
    @include('admin.shared.addImage')
    {{-- show selected image script --}}

    {{-- submit add form script --}}
        @include('admin.shared.submitAddForm')
    {{-- submit add form script --}}
    <script>
        $('.yearpicker').yearpicker()

        $(document).on('change' , '.have_chranic_disease' , function (e) {
            if($(this).val() == 1){
                $('.selectedInput').removeClass('d-none')
            }else{
                $(".selectedInputselect").val(0).trigger('change');
                $('.selectedInput').addClass('d-none')
            }
        });

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

    </script>
    
@endsection