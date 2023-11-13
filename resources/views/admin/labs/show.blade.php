@extends('admin.layout.master')

@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('admin.view') . ' ' . __('admin.lab')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form  class="show form-horizontal" >
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                     <div class="row">
                                        <div class="imgMontg col-6 text-center">
                                            <div class="dropBox">
                                                <div class="textCenter">
                                                    <div class="imagesUploadBlock">
                                                        <label class="uploadImg">
                                                            <span><i class="feather icon-image"></i></span>
                                                            <input type="file" accept="image/*" name="avatar"
                                                                class="imageUploader">
                                                        </label>
                                                        <div class="uploadedBlock">
                                                            <img src="{{$lab->image}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="imgMontg col-6 text-center">
                                            <div class="dropBox">
                                                <div class="textCenter">
                                                    <div class="imagesUploadBlock">
                                                        <label class="uploadImg">
                                                            <span><i class="feather icon-image"></i></span>
                                                            <input type="file" accept="image/*" name="avatar"
                                                                class="imageUploader">
                                                        </label>
                                                        <div class="uploadedBlock">
                                                            <img src="{{$lab->identity_image}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.name')}}</label>
                                            <div class="controls">
                                                <input type="text" name="name" value="{{$lab->name}}"
                                                    class="form-control" placeholder="{{__('admin.write_the_name')}}"
                                                    required
                                                    data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.phone') }}</label>
                                            <div class="controls">
                                                <input class="form-control"
                                                style="width: 20% ; position: absolute; left: 3%;"
                                                value="{{ $lab->country_code ?? '' }}">
                                                <input type="text" name="phone" value="{{ $lab->phone }}"
                                                    class="form-control"
                                                    placeholder="{{ __('admin.write_the_phone') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.email')}}</label>
                                            <div class="controls">
                                                <input type="email" name="email" value="{{$lab->email}}"
                                                    class="form-control" placeholder="{{__('admin.enter_the_email')}}"
                                                    required
                                                    data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.identity_number')}}</label>
                                            <div class="controls">
                                                <input type="number" name="phone" value="{{$lab->identity_number}}"
                                                    class="form-control"
                                                    placeholder="{{__('admin.identity_number')}}" required
                                                    data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('admin.status')}}</label>
                                            <div class="controls">
                                                <select name="is_blocked" class="select2 form-control" required
                                                    data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                                    <option value>{{__('admin.Select_the_blocking_status')}}</option>
                                                    <option {{$lab->is_blocked == 1 ? 'selected' : ''}}
                                                        value="1">{{__('admin.Prohibited')}}</option>
                                                    <option {{$lab->is_blocked == 0 ? 'selected' : ''}}
                                                        value="0">{{__('admin.Unspoken')}}</option>
                                                </select>
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
    <script>
        $('.show input').attr('disabled' , true)
        $('.show textarea').attr('disabled' , true)
        $('.show select').attr('disabled' , true)
    </script>
@endsection