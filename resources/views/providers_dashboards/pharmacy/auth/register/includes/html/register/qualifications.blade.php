<div class="tab-pane" role="tabpanel" id="step2">
    <input type="hidden" name="index" value="0">
    <!-- <form action="#"> -->
    <div>

        <div class="groups-inp">

            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">
                    @lang('localize.graduation_certificate_image')
                </h6>
                <div class="form__label">
                    <label for="filesNext2_input" class="apload-img-reg">
                        <input type="file" hidden data-single="true" onchange="abloadDefi(this)" id="filesNext2_input" class="heddenUploud files-input"
                            name="graduation_certification_image" data-input="filesNext2" accept="image/*" />
                        <div class="add-photo">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <div class="img-apload-title">
                            @lang('localize.please_enter_graduation_certificate_image')
                        </div>
                    </label>
                </div>
                <div class="error_show error_graduation_certification_image"> </div>
                <div class="uploaded__area" id="filesNext2_cont"></div>
            </div>
            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">
                    @lang('localize.graduation_certificate_pdf')
                </h6>
                <div class="form__label">
                    <label for="filesNext3_input" class="apload-img-reg">
                        <input type="file" hidden multiple id="filesNext3_input" data-single="true" onchange="abloadDefi(this)" class="heddenUploud files-input"
                            name="graduation_certification_pdf" data-input="filesNext3" accept="application/pdf" />
                        <div class="add-photo">
                            <i class="fa-solid fa-upload"></i>
                        </div>
                        <div class="img-apload-title">
                            @lang('localize.please_enter_graduation_certificate_pdf')
                        </div>
                    </label>
                </div>
                <div class="error_show error_graduation_certification_pdf"> </div>
                <div class="uploaded__area" id="filesNext3_cont"></div>
            </div>

            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">
                    @lang('localize.practice_certificate_image')
                </h6>
                <div class="form__label">
                    <label for="filesNext2_image_input" class="apload-img-reg">
                        <input type="file" hidden id="filesNext2_image_input" data-single="true" onchange="abloadDefi(this)" class="heddenUploud files-input"
                            name="practice_certification_image" data-input="filesNext2_image" accept="image/*" />
                        <div class="add-photo">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <div class="img-apload-title">
                            @lang('localize.please_enter_practice_certificate_image')
                        </div>
                    </label>
                </div>
                <div class="error_show error_practice_certification_image"> </div>
                <div class="uploaded__area" id="filesNext2_image_cont"></div>
            </div>
            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">
                    @lang('localize.practice_certificate_pdf')
                </h6>
                <div class="form__label">
                    <label for="filesNext3_pdf_input" class="apload-img-reg">
                        <input type="file" hidden multiple id="filesNext3_pdf_input" data-single="true" onchange="abloadDefi(this)" class="heddenUploud files-input"
                            name="practice_certification_pdf" data-input="filesNext3_pdf" accept="application/pdf" />
                        <div class="add-photo">
                            <i class="fa-solid fa-upload"></i>
                        </div>
                        <div class="img-apload-title">
                            @lang('localize.please_enter_practice_certificate_pdf')
                        </div>
                    </label>
                </div>
                <div class="error_show error_practice_certification_pdf"> </div>
                <div class="uploaded__area" id="filesNext3_pdf_cont"></div>
            </div>

            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">
                    @lang('localize.experience_certificate_image')
                </h6>
                <div class="form__label">
                    <label for="filesNext4_image_input" class="apload-img-reg">
                        <input type="file" hidden id="filesNext4_image_input" data-single="true" onchange="abloadDefi(this)" class="heddenUploud files-input"
                            name="experience_certification_image" data-input="filesNext4_image" accept="image/*" />
                        <div class="add-photo">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <div class="img-apload-title">
                            @lang('localize.please_enter_experience_certificate_image')
                        </div>
                    </label>
                </div>
                <div class="error_show error_experience_certification_image"> </div>
                <div class="uploaded__area" id="filesNext4_image_cont"></div>
            </div>
            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">
                    @lang('localize.experience_certificate_pdf')
                </h6>
                <div class="form__label">
                    <label for="filesNext4_pdf_input" class="apload-img-reg">
                        <input type="file" hidden multiple id="filesNext4_pdf_input" data-single="true" onchange="abloadDefi(this)" class="heddenUploud files-input"
                            name="experience_certification_pdf" data-input="filesNext4_pdf" accept="application/pdf" />
                        <div class="add-photo">
                            <i class="fa-solid fa-upload"></i>
                        </div>
                        <div class="img-apload-title">
                            @lang('localize.please_enter_experience_certificate_pdf')
                        </div>
                    </label>
                </div>
                <div class="error_show error_experience_certification_pdf"> </div>
                <div class="uploaded__area" id="filesNext4_pdf_cont"></div>
            </div>

            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">@lang('localize.experience_years')</h6>
                <div class="form__label">
                    <input class="default_input" name="experience_years" onchange="abloadDefi(this)" type="text"
                        placeholder="@lang('localize.please_enter_experience_years')" />
                    <label class="float__label" for="">@lang('localize.please_enter_experience_years')</label>
                </div>
                <div class="error_show error_experience_years"> </div>
            </div>

        </div>
    </div>

    <!-- </form> -->
    <ul class="list-inline">
        <button type="button" class="default-btn next-step up">
            @lang('localize.next')
        </button>
    </ul>
</div>
