<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">

            <div class="modal-body no-border-bottom modal1-spe">
                <h5 class="font-17 font_bold mb-3 ">{{ __('store.edit') . ' ' .__('store.Personal data') }}</h5>
                <form action="{{ route('doctor.profile.update') }}" method="POST" data-type="profile" enctype="multipart/form-data" class="form">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <div class="img-cont-spe">
                            <img src="{{ $doctor->image }}" alt="" id="change-profile">
                            <label class="edit-spe" for="img-up"><i class="fa-regular fa-pen-to-square"></i>
                                <input onchange="loadFiles(event)" name="image" type="file" id="img-up" hidden>
                            </label>
                            <div class="error_show error_image"> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.name') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" value="{{ $doctor->name }}" name="name" type="text"  placeholder="{{ __('store.name') }}" />
                                    <label class="float__label" for="">{{ __('store.name_val') }}</label>
                                </div>
                                <div class="error_show error_name"> </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                                <h6 class="fontBold mainColor font14">{{ __('store.Mobile number') }}</h6>
                            <div class="form__label overflowx-v input-g input-group-full age-date inp-cont-spe mb-3 code-country">
                                <input type="hidden" id="country_code" name="country_code" value="{{ $doctor->country_code }}">
                                    <div class="flex-nums-s">
                                        <input
                                                type="tel"
                                                id="telephone"
                                                value="+{{ $doctor->country_code }}"
                                                name=""
                                        />
                                        <input class="placeholder-spe inp-spe num-inp-spe"  value="{{ $doctor->phone }}" name="phone" type="number"  placeholder="{{ __('store.phone_val') }}" />

                                    </div>
                                </div>

                            <div class="d-flex error_group mb-2">
                                <div class="error_show error_country_code"> </div>
                                <div class="error_show error_phone"> </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <h6 class="fontBold mainColor font14">@lang('localize.age')</h6>
                            <div class="form__label">
                                <input class="default_input" value="{{ $doctor->age }}" name="age" type="number" placeholder="@lang('localize.pe_age')" />
                                <label class="float__label" for="">@lang('localize.pe_age')</label>
                            </div>
                            <div class="error_show error_age"> </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <h6 class="fontBold mainColor font14">@lang('localize.experience_years')</h6>
                            <div class="form__label">
                                <input class="default_input" value="{{ $doctor->experience_years  }}" name="experience_years" type="text" placeholder="@lang('translate.pe_experience_years')" />
                                <label class="float__label" for="">{{ __('translation.pe_experience_years') }}</label>
                            </div>
                            <div class="error_show error_experience_years"> </div>
                        </div>



                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.email') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" value="{{ $doctor->email }}" name="email" type="email"  placeholder="{{ __('store.email_val') }}" />
                                    <label class="float__label" for="">{{ __('store.email_val') }}</label>
                                </div>
                                <div class="error_show error_email"> </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.ID Number') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" value="{{ $doctor->identity_number }}" name="identity_number" type="number"  placeholder="{{ __('store.ID Number_val') }}" />
                                    <label class="float__label" for="">{{ __('store.ID Number_val') }}</label>
                                </div>
                                <div class="error_show error_identity_number"> </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <h6 class="mb-3 fontBold mainColor font14">
                                @lang('localize.main_speciality')
                            </h6>
                            <div class="form__label">
                                <select name="category_id" class=" main_speciality default_input">
                                    <option selected disabled>@lang('localize.pc_main_speciality')</option>
                                    @foreach ($categories as $category)
                                        <option {{ optional($subCategory)->id == $category->id || optional($singleCategory)->id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12 sub_speciality main-inp-cont"></div>



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
