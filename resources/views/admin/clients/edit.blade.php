@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/yearpicker.css') }}">
@endsection
{{-- extra css files --}}

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.edit') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.clients.update', ['id' => $row->id]) }}"
                                class="store form-horizontal" novalidate>
                                @csrf
                                @method('PUT')
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="imgMontg col-12 text-center">
                                                <div class="dropBox">
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*" name="image"
                                                                    class="imageUploader">
                                                            </label>
                                                            <div class="uploadedBlock">
                                                                <img src="{{ $row->image }}">
                                                                <button class="close"><i class="la la-times"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.name') }}</label>
                                                <div class="controls">
                                                    <input type="text" name="name" value="{{ $row->name }}"
                                                        class="form-control" placeholder="{{ __('admin.write_the_name') }}"
                                                        required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.phone_number') }}</label>
                                                <div class="controls">
                                                    <input type="number" name="phone" value="{{ $row->phone }}"
                                                        class="form-control"
                                                        placeholder="{{ __('admin.enter_phone_number') }}" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                        data-validation-number-message="{{ __('admin.the_phone_number_ must_not_have_charachters_or_symbol') }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.email') }}</label>
                                                <div class="controls">
                                                    <input type="email" name="email" value="{{ $row->email }}"
                                                        class="form-control"
                                                        placeholder="{{ __('admin.enter_the_email') }}" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                        data-validation-email-message="{{ __('admin.email_formula_is_incorrect') }}">
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.password') }}</label>
                                                <div class="controls">
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.weight') }}</label>
                                                <div class="controls">
                                                    <input type="number" name="weight" value="{{ $row->weight }}"
                                                        class="form-control"
                                                        placeholder="{{ __('admin.enter_the_weight') }}" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.height') }}</label>
                                                <div class="controls">
                                                    <input type="number" name="height" value="{{ number_format($row->height)}}"
                                                        class="form-control"
                                                        placeholder="{{ __('admin.write_the_height') }}" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{__('admin.age')}}</label>
                                                <div class="controls">
                                                    <input type="" value="" name="age" class="form-control yearpicker" placeholder="{{__('admin.write_the_date')}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-column">{{ __('admin.have_chranic_disease') }}</label>
                                                <div class="controls">
                                                    <select name="has_diseases"
                                                        class="select2 have_chranic_disease form-control" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                        <option value disabled>{{ __('admin.have_chranic_disease') }}
                                                        </option>
                                                        <option {{ $row->has_diseases == 1 ? 'selected' : '' }}
                                                            value="1">{{ __('admin.true') }}</option>
                                                        <option {{ $row->has_diseases == 0 ? 'selected' : '' }}
                                                            value="0">{{ __('admin.false') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12 selectedInput {{$row->has_diseases == 1 ? '' : 'd-none'}} ">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.chranic_disease') }}</label>
                                                <div class="controls">
                                                    <select multiple name="chranic_disease_ids[]" class="select2 form-control" id="my_select2">
                                                        <option value disabled>{{ __('admin.chranic_disease') }}</option>
                                                        @foreach ($chranicdiseases as $chranic)
                                                            <option  value="{{$chranic->id}}"> {{ $chranic->name }} </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.gender') }}</label>
                                                <div class="controls">
                                                    <select name="gender" class="select2 form-control" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                        <option value disabled>{{ __('admin.gender') }}</option>
                                                        <option {{ $row->gender == 'male' ? 'selected' : '' }}
                                                            value="male">{{ __('admin.male') }}</option>
                                                        <option {{ $row->gender == 'female' ? 'selected' : '' }}
                                                            value="female">{{ __('admin.female') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.bloodtype') }}</label>
                                                <div class="controls">
                                                    <select name="blood_type_id" class="select2 form-control">
                                                        <option value disabled>{{ __('admin.bloodtype') }}</option>
                                                        @foreach ($bloodTypes as $type)
                                                            <option
                                                                {{ $type->id == $row->blood_type_id ? 'selected' : '' }}
                                                                value="{{ $type->id }}">{{ $type->name }}
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.Validity') }}</label>
                                                <div class="controls">
                                                    <select name="is_blocked" class="select2 form-control" required
                                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                        <option value>{{ __('admin.Select_the_blocking_status') }}</option>
                                                        <option {{ $row->is_blocked == 1 ? 'selected' : '' }}
                                                            value="1">{{ __('admin.Prohibited') }}</option>
                                                        <option {{ $row->is_blocked == 0 ? 'selected' : '' }}
                                                            value="0">{{ __('admin.Unspoken') }}</option>
                                                    </select>
                                                </div>
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

    <script src="{{ asset('admin/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/forms/select/form-select2.js') }}"></script>
    <script src="{{ asset('dist/yearpicker.js') }}"></script>

    


    {{-- show selected image script --}}
    @include('admin.shared.addImage')
    {{-- show selected image script --}}

    {{-- submit edit form script --}}
    @include('admin.shared.submitEditForm')
    {{-- submit edit form script --}}

    <script>
        $(function() {
            $("#my_select2").select2();
            $("#my_select2").val( @json($disease));
            $("#my_select2").trigger('change');
        })
        $('.yearpicker').yearpicker({
            year: '{{$row->age}}',
        })

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
