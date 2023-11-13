<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">

            <div class="modal-body no-border-bottom modal1-spe">
                <h5 class="font-17 font_bold mb-3 ">{{ __('store.permit_add') }}</h5>
                <form action="{{ route('lab.profile.permit.store') }}" method="POST" enctype="multipart/form-data" data-type="profile" class="form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.permit_name') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" name="name" type="text"  placeholder="{{ __('store.permit_name_val') }}" />
                                    <label class="float__label" for="">{{ __('store.permit_name_val') }}</label>
                                </div>
                                <div class="error_show error_name"> </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.permit_image') }}</h6>
                                <div class="form__label">
                                    <label for="filesNext1_input" class="apload-img-reg">
                                        <input type="file" hidden onchange="abloadDefi(this)" id="filesNext1_input"
                                               class="heddenUploud files-input" name="image" accept="image/*" data-input="filesNext1" />
                                        <div class="add-photo">
                                            <i class="fa-solid fa-images"></i>
                                        </div>
                                        <div class="img-apload-title">{{ __('store.permit_image_val') }}</div>
                                    </label>

                                </div>
                                <div class="error_show error_image"> </div>
                                <div class="uploaded__area" id="filesNext1_cont"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.permit_file') }}</h6>
                                <div class="form__label">
                                    <label for="filesNext2_input" class="apload-img-reg">
                                        <input type="file" onchange="abloadDefi(this)" hidden id="filesNext2_input"
                                               class="heddenUploud files-input" name="file" accept="application/pdf" data-input="filesNext2" />
                                        <div class="add-photo">
                                            <i class="fa-solid fa-upload"></i>
                                        </div>
                                        <div class="img-apload-title">{{ __('store.permit_file_val') }} </div>
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
