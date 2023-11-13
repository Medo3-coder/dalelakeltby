<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">

            <div class="modal-body no-border-bottom modal1-spe">
                <h5 class="font-17 font_bold mb-3 ">{{ __('translation.Add a qualifier') }}</h5>
                <form action="{{ route('pharmacy.profile.permit.store') }}" data-type="profile" method="POST" enctype="multipart/form-data" class="form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('translation.Certificate name') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" name="name" type="text"  placeholder="{{ __('store.Please indicate the name of the certificate') }}" />
                                    <label class="float__label" for="">{{ __('translation.Please indicate the name of the certificate') }}</label>
                                </div>
                                <div class="error_show error_name"> </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('translation.Certificate copy') }}</h6>
                                <div class="form__label">
                                    <label for="filesNext1_input" class="apload-img-reg">
                                        <input type="file" hidden onchange="abloadDefi(this)" id="filesNext1_input"
                                               class="heddenUploud files-input" name="image" accept="image/*" data-input="filesNext1" />
                                        <div class="add-photo">
                                            <i class="fa-solid fa-images"></i>
                                        </div>
                                        <div class="img-apload-title">{{ __('translation.Please add a picture of the certificate') }}</div>
                                    </label>

                                </div>
                                <div class="error_show error_image"> </div>
                                <div class="uploaded__area" id="filesNext1_cont"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('translation.Testimony (PDF)') }}</h6>
                                <div class="form__label">
                                    <label for="filesNext2_input" class="apload-img-reg">
                                        <input type="file" onchange="abloadDefi(this)" hidden id="filesNext2_input"
                                               class="heddenUploud files-input" name="file" accept="application/pdf" data-input="filesNext2" />
                                        <div class="add-photo">
                                            <i class="fa-solid fa-upload"></i>
                                        </div>
                                        <div class="img-apload-title">{{ __('translation.Please add the certificate') }} </div>
                                    </label>
                                </div>
                                <div class="error_show error_file"> </div>
                                <div class="uploaded__area" id="filesNext2_cont"></div>
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