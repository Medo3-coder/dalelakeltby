@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
@endsection
{{-- extra css files --}}
@section('content')

<div class="content-body">
  <!-- account setting page start -->
  <section id="page-account-settings">
      <div class="row">
          <!-- left menu section -->
          <div class="col-md-3 mb-2 mb-md-0">
              <ul class="nav nav-pills flex-column mt-md-0 mt-1">

                  <li class="nav-item">
                      <a class="nav-link d-flex py-75 active" id="account-pill-main" data-toggle="pill" href="#account-vertical-main" aria-expanded="true">
                          <i class="feather icon-settings mr-50 font-medium-3"></i>
                          {{__('admin.app_setting')}}
                      </a>
                  </li>
                  <li class="nav-item" style="margin-top: 3px" > 
                      <a class="nav-link d-flex py-75" id="account-pill-terms" data-toggle="pill" href="#account-vertical-terms" aria-expanded="false">
                          <i class="feather icon-edit-1 mr-50 font-medium-3"></i>
                          {{__('admin.terms_and_conditions')}}
                      </a>
                  </li>
                  <li class="nav-item " style="margin-top: 3px">
                      <a class="nav-link d-flex py-75" id="account-pill-about" data-toggle="pill" href="#account-vertical-about" aria-expanded="false">
                          <i class="feather icon-edit-1 mr-50 font-medium-3"></i>
                          {{__('admin.about_app')}}
                      </a>
                  </li>
                  <li class="nav-item " style="margin-top: 3px">
                      <a class="nav-link d-flex py-75" id="account-pill-privacy" data-toggle="pill" href="#account-vertical-privacy" aria-expanded="false">
                          <i class="feather icon-award mr-50 font-medium-3"></i>
                          {{__('admin.Privacy_policy')}}
                      </a>
                  </li>
                  <li class="nav-item " style="margin-top: 3px">
                      <a class="nav-link d-flex py-75" id="account-pill-smtp" data-toggle="pill" href="#account-vertical-smtp" aria-expanded="false">
                          <i class="feather icon-mail mr-50 font-medium-3"></i>
                          {{__('admin.email_data')}}
                      </a>
                  </li>
                  <li class="nav-item " style="margin-top: 3px">
                      <a class="nav-link d-flex py-75" id="account-pill-notifications" data-toggle="pill" href="#account-vertical-notifications" aria-expanded="false">
                          <i class="feather icon-bell mr-50 font-medium-3"></i>
                          {{__('admin.notification_data')}}
                      </a>
                  </li>
                  <li class="nav-item " style="margin-top: 3px">
                      <a class="nav-link d-flex py-75" id="account-pill-api" data-toggle="pill" href="#account-vertical-api" aria-expanded="false">
                          <i class="feather icon-droplet mr-50 font-medium-3"></i>
                          {{__('admin.api_data')}}
                      </a>
                  </li>

              </ul>
          </div>
          <!-- right content section -->
          <div class="col-md-9">
              <div class="card">
                  <div class="card-content">
                      <div class="card-body">
                          <div class="tab-content">

                              <div role="tabpanel" class="tab-pane active" id="account-vertical-main" aria-labelledby="account-pill-main" aria-expanded="true">
                                <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data" class="form-horizontal" novalidate>
                                  @method('put')
                                  @csrf
                                <div class="row">
                                  <div class="col-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account-name">{{__('admin.the_name_of_the_application_in_arabic')}}</label>
                                                <input type="text" class="form-control" name="name_ar" id="account-name" placeholder="{{__('admin.the_name_of_the_application_in_arabic')}}" value="{{$data['name_ar']}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account-name">{{__('admin.the_name_of_the_application_in_english')}}</label>
                                                <input type="text" class="form-control" name="name_en" id="account-name" placeholder="{{__('admin.the_name_of_the_application_in_english')}}" value="{{$data['name_en']}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account-name">{{__('admin.email')}}</label>
                                                <input type="email" class="form-control" name="email" id="account-name" placeholder="{{__('admin.email')}}" value="{{$data['email']}}" data-validation-email-message="{{__('admin.verify_the_email_format')}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account-name">{{__('admin.phone')}}</label>
                                                <input type="text" class="form-control" name="phone" id="account-name" placeholder="{{__('admin.phone')}}" value="{{$data['phone']}}" minlength="10" required data-validation-required-message="{{__('admin.this_field_is_required')}}" data-validation-minlength-message="{{__('admin.the_number_should_only_be_less_than_ten_numbers')}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account-name">{{__('admin.whatts_app_number')}}</label>
                                                <input type="text" class="form-control" name="whatsapp" id="account-name" placeholder="{{__('admin.whatts_app_number')}}" value="{{$data['whatsapp']}}" minlength="10"  data-validation-minlength-message="{{__('admin.the_number_should_only_be_less_than_ten_numbers')}}"  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account-name">{{__('admin.reservations_number_per_day')}}</label>
                                                <input type="text" class="form-control" name="reservations_number_per_day" id="account-name" placeholder="{{__('admin.reservations_number_per_day')}}" value="{{$data['reservations_number_per_day']}}"  >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="controls">
                                                <label for="account-name">{{__('admin.reservation_price')}}</label>
                                                <input type="text" class="form-control" name="reservation_price" id="account-name" placeholder="{{__('admin.reservation_price')}}" value="{{$data['reservation_price']}}"  >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="account-name">is production </label>
                                            <div class="custom-control custom-switch custom-switch-success mr-2 mb-1">
                                                <input name="is_production" {{$data['is_production']  == '1' ? 'checked' : ''}}   type="checkbox" class="custom-control-input" id="customSwitch11">
                                                <label class="custom-control-label" for="customSwitch11">
                                                    <span class="switch-icon-left"><i class="feather icon-check"></i></span>
                                                    <span class="switch-icon-right"><i class="feather icon-check"></i></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                      <div class="row">

                                        <div class="imgMontg col-2 text-center">
                                            <div class="dropBox">
                                                <div class="textCenter d-flex flex-lg-column">
                                                    <div class="imagesUploadBlock">
                                                        <label class="uploadImg">
                                                            <span><i class="feather icon-image"></i></span>
                                                            <input type="file" accept="image/*" name="logo" class="imageUploader">
                                                        </label>
                                                        <div class="uploadedBlock">
                                                            <img src="{{$data['logo']}}">
                                                            <button class="close"><i class="feather icon-trash-2"></i></button>
                                                        </div>
                                                      </div>
                                                      <span>{{__('admin.logo_image')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="imgMontg col-2 text-center">
                                            <div class="dropBox">
                                                <div class="textCenter d-flex flex-lg-column">
                                                    <div class="imagesUploadBlock">
                                                        <label class="uploadImg">
                                                            <span><i class="feather icon-image"></i></span>
                                                            <input type="file" accept="image/*" name="fav_icon" class="imageUploader">
                                                        </label>
                                                        <div class="uploadedBlock">
                                                            <img src="{{$data['fav_icon']}}">
                                                            <button class="close"><i class="feather icon-trash-2"></i></button>
                                                        </div>
                                                      </div>
                                                      <span>{{__('admin.fav_icon_image')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="imgMontg col-2 text-center">
                                            <div class="dropBox">
                                                <div class="textCenter d-flex flex-lg-column">
                                                    <div class="imagesUploadBlock">
                                                        <label class="uploadImg">
                                                            <span><i class="feather icon-image"></i></span>
                                                            <input type="file" accept="image/*" name="login_background" class="imageUploader">
                                                        </label>
                                                        <div class="uploadedBlock">
                                                            <img src="{{$data['login_background']}}">
                                                            <button class="close"><i class="feather icon-trash-2"></i></button>
                                                        </div>
                                                      </div>
                                                      <span>{{__('admin.background_image')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="imgMontg col-2 text-center">
                                            <div class="dropBox">
                                                <div class="textCenter d-flex flex-lg-column">
                                                    <div class="imagesUploadBlock">
                                                        <label class="uploadImg">
                                                            <span><i class="feather icon-image"></i></span>
                                                            <input type="file" accept="image/*" name="default_user" class="imageUploader">
                                                        </label>
                                                        <div class="uploadedBlock">
                                                            <img src="{{$data['default_user']}}">
                                                            <button class="close"><i class="feather icon-trash-2"></i></button>
                                                        </div>
                                                      </div>
                                                      <span>{{__('admin.virtual_user_image')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                      </div>

                                    </div>
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                                        <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
                                    </div>
                                </div>
                                </form>
                              </div>

                              <div role="tabpanel" class="tab-pane" id="account-vertical-terms" aria-labelledby="account-pill-terms" aria-expanded="false">
                                <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.conditions_and_conditions_in_arabic')}}</label>
                                                    <textarea class="form-control" name="terms_ar" id="terms_ar_editor" cols="30" rows="10" placeholder="{{__('admin.terms_and_conditions')}}">{{$data['terms_ar']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.conditions_and_conditions_of_english')}}</label>
                                                    <textarea class="form-control" name="terms_en" id="terms_en_editor" cols="30" rows="10" placeholder="{{__('admin.terms_and_conditions')}}">{{$data['terms_en']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                          <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                                          <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
                                      </div>
                                    </div>
                                </form>
                              </div>

                              <div role="tabpanel" class="tab-pane" id="account-vertical-about" aria-labelledby="account-pill-about" aria-expanded="false">
                                <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.about_the_application_in_arabic')}}</label>
                                                    <textarea class="form-control" name="about_ar" id="about_ar_editor" cols="30" rows="10" placeholder="{{__('admin.about_the_application_in_arabic')}}">{{$data['about_ar']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.about_the_application_in_english')}}</label>
                                                    <textarea class="form-control" name="about_en" id="about_en_editor" cols="30" rows="10" placeholder="{{__('admin.about_the_application_in_english')}}">{{$data['about_en']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                          <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                                          <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
                                      </div>
                                    </div>
                                </form>
                              </div>

                              <div role="tabpanel" class="tab-pane" id="account-vertical-privacy" aria-labelledby="account-pill-privacy" aria-expanded="false">
                                <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.privacy_policy_in_arabic')}}</label>
                                                    <textarea class="form-control" name="privacy_ar" id="privacy_ar_editor" cols="30" rows="10" placeholder="{{__('admin.privacy_policy_in_arabic')}}">{{$data['privacy_ar']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.privacy_policy_in_english')}}</label>
                                                    <textarea class="form-control" name="privacy_en" id="privacy_en_editor" cols="30" rows="10" placeholder="{{__('admin.privacy_policy_in_english')}}">{{$data['privacy_en']}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                          <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                                          <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
                                      </div>
                                    </div>
                                </form>
                              </div>

                              <div role="tabpanel" class="tab-pane" id="account-vertical-smtp" aria-labelledby="account-pill-smtp" aria-expanded="false">
                                <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.user_name')}}</label>
                                                    <input type="text" class="form-control" name="smtp_user_name" id="account-name" placeholder="{{__('admin.user_name')}}" value="{{$data['smtp_user_name']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.password')}}</label>
                                                    <input type="password" class="form-control" name="smtp_password" id="account-name" placeholder="{{__('admin.password')}}" value="{{$data['smtp_password']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.email_Sender')}}</label>
                                                    <input type="text" class="form-control" name="smtp_mail_from" id="account-name" placeholder="{{__('admin.email_Sender')}}" value="{{$data['smtp_mail_from']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.the_sender_name')}}</label>
                                                    <input type="text" class="form-control" name="smtp_sender_name" id="account-name" placeholder="{{__('admin.the_sender_name')}}" value="{{$data['smtp_sender_name']}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.the_nouns_al')}}</label>
                                                    <input type="text" class="form-control" name="smtp_host" id="account-name" placeholder="{{__('admin.the_nouns_al')}}" value="{{$data['smtp_host']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.encryption_type')}}</label>
                                                    <input type="text" class="form-control" name="smtp_encryption" id="account-name" placeholder="{{__('admin.encryption_type')}}" value="{{$data['smtp_encryption']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.Port_number')}}</label>
                                                    <input type="number" class="form-control" name="smtp_port" id="account-name" placeholder="{{__('admin.Port_number')}}" value="{{$data['smtp_port']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-center mt-3">
                                          <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                                          <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
                                      </div>
                                    </div>
                                </form>
                              </div>

                              <div role="tabpanel" class="tab-pane" id="account-vertical-notifications" aria-labelledby="account-pill-notifications" aria-expanded="false">
                                <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.server_key')}}</label>
                                                    <input type="text" class="form-control" name="firebase_key" id="account-name" placeholder="{{__('admin.server_key')}}" value="{{$data['firebase_key']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.sender_identification')}}</label>
                                                    <input type="text" class="form-control" name="firebase_sender_id" id="account-name" placeholder="{{__('admin.sender_identification')}}" value="{{$data['firebase_sender_id']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-center mt-3">
                                          <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                                          <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
                                      </div>
                                    </div>
                                </form>
                              </div>

                              <div role="tabpanel" class="tab-pane" id="account-vertical-api" aria-labelledby="account-pill-api" aria-expanded="false">
                                <form accept="{{route('admin.settings.update')}}" method="post" enctype="multipart/form-data">
                                    @method('put')
                                    @csrf
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.live_chat')}}</label>
                                                    <input type="text" class="form-control" name="live_chat" id="account-name" placeholder="{{__('admin.live_chat')}}" value="{{$data['live_chat']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.google_analytics')}}</label>
                                                    <input type="text" class="form-control" name="google_analytics" id="account-name" placeholder="{{__('admin.google_analytics')}}" value="{{$data['google_analytics']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label for="account-name">{{__('admin.google_places')}}</label>
                                                    <input type="text" class="form-control" name="google_places" id="account-name" placeholder="{{__('admin.google_places')}}" value="{{$data['google_places']}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-center mt-3">
                                          <button type="submit" class="btn btn-primary mr-1 mb-1 submit_button">{{__('admin.saving_changes')}}</button>
                                          <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
                                      </div>
                                    </div>
                                </form>
                              </div>

                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- account setting page end -->

</div>

@endsection
@section('js')
    <script src="{{asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
    <script src="{{asset('admin/app-assets/js/scripts/forms/validation/form-validation.js')}}"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/full-all/ckeditor.js"></script>
    <script>
            CKEDITOR.replace( 'terms_ar_editor' );
            CKEDITOR.replace( 'terms_en_editor' );
            CKEDITOR.replace( 'privacy_ar_editor' );
            CKEDITOR.replace( 'privacy_en_editor' );
            CKEDITOR.replace( 'about_ar_editor' );
            CKEDITOR.replace( 'about_en_editor' );
    </script>
  {{-- show selected image script --}}
    @include('admin.shared.addImage')
  {{-- show selected image script --}}
@endsection

