<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">

            <div class="modal-body no-border-bottom modal1-spe">
                <h5 class="font-17 font_bold mb-3 ">{{ __('store.edit') . ' ' .__('store.Personal data') }}</h5>
                <form action="{{ route('lab.profile.update') }}" method="POST" enctype="multipart/form-data" data-type="profile" class="form">
                    @csrf
                    @method('PUT')
                    <div class="">
                        <div class="img-cont-spe">
                            <img src="{{ $lab->image }}" alt="" id="change-profile">
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
                                    <input class="default_input" value="{{ $lab->name }}" name="name" type="text"  placeholder="{{ __('store.name') }}" />
                                    <label class="float__label" for="">{{ __('store.name_val') }}</label>
                                </div>
                                <div class="error_show error_name"> </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <h6 class="fontBold mainColor font14">{{ __('store.Mobile number') }}</h6>
                            <div class="form__label overflowx-v input-g input-group-full age-date inp-cont-spe mb-3 code-country">
                                <input type="hidden" id="country_code" name="country_code" value="{{ $lab->country_code }}">
                                <div class="flex-nums-s">
                                    <input
                                            type="tel"
                                            id="telephone"
                                            value="+{{ $lab->country_code }}"
                                            name=""
                                    />
                                    <input class="placeholder-spe inp-spe num-inp-spe"  value="{{ $lab->phone }}" name="phone" type="number"  placeholder="{{ __('store.phone_val') }}" />

                                </div>
                            </div>

                            <div class="d-flex error_group mb-2">
                                <div class="error_show error_country_code"> </div>
                                <div class="error_show error_phone"> </div>
                            </div>


                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.email') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" value="{{ $lab->email }}" name="email" type="email"  placeholder="{{ __('store.email_val') }}" />
                                    <label class="float__label" for="">{{ __('store.email_val') }}</label>
                                </div>
                                <div class="error_show error_email"> </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.ID Number') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" value="{{ $lab->identity_id }}" name="identity_id" type="number"  placeholder="{{ __('store.ID Number_val') }}" />
                                    <label class="float__label" for="">{{ __('store.ID Number_val') }}</label>
                                </div>
                                <div class="error_show error_identity_id"> </div>
                            </div>
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
