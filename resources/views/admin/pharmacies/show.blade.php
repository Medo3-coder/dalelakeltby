@extends('admin.layout.master')

@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('admin.view') . ' ' . __('admin.pharmacies')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="show form-horizontal">
                            <div class="form-body">

                                <div class="row">
                                        <div class="col-2">
                                            <div class="imgMontg col-12 text-center">
                                                <div class="dropBox">
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*"
                                                                    name="image" class="imageUploader">
                                                            </label>
                                                            <div class="uploadedBlock">
                                                                <img src="{{ $row->image }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                       



                                        <div class="col-2">
                                            <div class="imgMontg col-12 text-center">
                                                <div class="dropBox">
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*"
                                                                    name="image" class="imageUploader">
                                                            </label>
                                                            <div class="uploadedBlock">
                                                                <img src="{{ $row->GraduationCertificationImage }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                           

                                        <div class="col-2">
                                            <div class="imgMontg col-12 text-center">
                                                <div class="dropBox">
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*"
                                                                    name="image" class="imageUploader">
                                                            </label>
                                                            <div class="uploadedBlock">
                                                                <img src="{{ $row->ExperienceCertificationImage }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="col-2">
                                            <div class="imgMontg col-12 text-center">
                                                <div class="dropBox">
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*"
                                                                    name="image" class="imageUploader">
                                                            </label>
                                                            <div class="uploadedBlock">
                                                                <img src="{{ $row->PracticeCertificationImage }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-2">
                                            <div class="imgMontg col-12 text-center">
                                                <div class="dropBox">
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*"
                                                                    name="image" class="imageUploader">
                                                            </label>
                                                            <div class="uploadedBlock">
                                                                <img src="{{ $row->IdentityImage }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {{-- </div> --}}

                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.name') }}</label>
                                            <div class="controls">
                                                <input type="text" name="name" value="{{ $row->name }}"
                                                    class="form-control"
                                                    placeholder="{{ __('admin.write_the_name') }}">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.email') }}</label>
                                            <div class="controls">
                                                <input type="text" name="name" value="{{ $row->email }}"
                                                    class="form-control"
                                                    placeholder="{{ __('admin.write_the_email') }}">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.phone') }}</label>
                                            <div class="controls">
                                                <input class="form-control"
                                                style="width: 20% ; position: absolute; left: 3%;"
                                                value="{{ $row->country_code ?? '' }}">
                                                <input type="text" name="phone" value="{{ $row->phone }}"
                                                    class="form-control"
                                                    placeholder="{{ __('admin.write_the_phone') }}">
                                            </div>
                                        </div>
                                    </div>


                                    {{-- <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.phone') }}</label>
                                            <div class="controls">
                                                <input type="text" name="phone" value="{{ $row->phone }}"
                                                    class="form-control"
                                                    placeholder="{{ __('admin.write_the_phone') }}">
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account-name">{{ __('admin.identity_number') }}</label>
                                                <input type="number" class="form-control" name="identity_number"
                                                value="{{ $row->identity_number }}">
                                            </div>
                                        </div>
                                    </div>

                                    

                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label
                                                for="first-name-column">{{ __('admin.experience_years') }}</label>
                                            <div class="controls">
                                                <input type="number" name="experience_years"
                                                    value="{{ $row->experience_years }}"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account-name">{{ __('admin.age') }}</label>
                                                <input type="number" class="form-control" name="age"
                                                value="{{ $row->age }}">
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
                                                    <option {{$row->is_blocked == 1 ? 'selected' : ''}}
                                                        value="1">{{__('admin.Prohibited')}}</option>
                                                    <option {{$row->is_blocked == 0 ? 'selected' : ''}}
                                                        value="0">{{__('admin.Unspoken')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label
                                                for="first-name-column">{{ __('admin.experience_certification_pdf') }}</label>
                                            <div class="controls">
                                                <a   href="{{$row->ExperienceCertificationPdf ?? ''}}" download> <i class="feather icon-arrow-down">  </i></a>
                                         
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label
                                                for="first-name-column">{{ __('admin.practice_certification_pdf') }}</label>
                                            <div class="controls">
                                                <a   href="{{$row->PracticeCertificationPdf ?? ''}}" download> <i class="feather icon-arrow-down">  </i></a>
                                         
                                            </div>
                                        </div>
                                        



                                          <div class="form-group">
                                            <label
                                                for="first-name-column">{{ __('admin.graduation_certification_pdf') }}</label>
                                            <div class="controls">
                                                <a   href="{{$row->GraduationCertificationPdf ?? ''}}" download> <i class="feather icon-arrow-down">  </i></a>
                                         
                                            </div>
                                        </div>
                                    </div>



                                   
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <a href="{{ url()->previous() }}" type="reset"
                                            class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
                                    </div>

                                </div>

                            {{-- </div> --}}
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