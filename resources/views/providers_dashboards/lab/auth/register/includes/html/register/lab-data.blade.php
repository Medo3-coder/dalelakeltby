<div class="tab-pane" role="tabpanel" id="step2">
    <!-- <form action="#"> -->
    <div class="add-append">
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">@lang('localize.lab_name')</h6>
            <div class="form__label">
                <input class="default_input" name="branches[0][name]" type="text" placeholder="@lang('localize.pe_lab_name')" />
                <label class="float__label" for="">@lang('localize.pe_lab_name')</label>
            </div>
            <div class="error_show error_branches.0.name"> </div>
        </div>

        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">
                {{ __('translation.lab_address') }}
            </h6>
            <div class="form__label">
                <input class="default_input" name="branches[0][address]" type="text"  placeholder="{{ __('translation.lab_address_val') }}" />
                <label class="float__label" for="">{{ __('translation.lab_address_val') }}</label>
            </div>
            <div class="error_show error_branches.0.address"> </div>
        </div>


        <div class="mb-3 main-inp-cont">
            <div class="maps">
                <div class="mb-3 main-inp-cont">
                    <h6 class="fontBold mainColor font14">
                        @lang('localize.lab_location_on_map')
                    </h6>
                    <div class="form__label">
                        <input type="hidden" name="branches[0][lat]" class="lat" value="31.04035945880287">
                        <input type="hidden" name="branches[0][lng]" class="lng" value="31.37892723083496">
                        <input class="default_input address" name="branches[0][address_map]" readonly type="text"
                            placeholder="{{ __('store.store_address_map_val') }}t" />
                        <label class="float__label" for="">{{ __('store.store_address_map_val') }}</label>
                        <div class="add-photo">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                </div>
                <div id="" style="width: 100%; height: 320px" class="mb-3 map"></div>
            </div>
            <div class="error_show error_branches.0.lat"> </div>
            <div class="error_show error_branches.0.lng"> </div>
            <div class="error_show error_branches.0.address"> </div>
        </div>



        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">
                @lang('localize.lab_comerical_number')
            </h6>
            <div class="form__label">
                <input name="branches[0][comerical_record]" class="default_input" type="number"
                    placeholder=" @lang('localize.pe_clinic_comerical_number')" />
                <label class="float__label" for="">@lang('localize.pe_clinic_comerical_number')</label>
            </div>
            <div class="error_show error_branches.0.comerical_record"> </div>
        </div>

        <div class="groups-inp">

            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">@lang('localize.lab_open_cerificate_image')</h6>
                <div class="form__label ">
                    <label for="filesNext_image_0_input" class="apload-img-reg">
                        <div class="add-photo">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <div class="img-apload-title">
                            @lang('localize.lab_open_cerificate_image')
                        </div>
                    </label>
                    <input type="file" onchange="abloadDefi(this)" hidden id="filesNext_image_0_input"
                        class="heddenUploud files-input" data-single="true"
                        name="branches[0][opening_certificate_image]" data-input="filesNext_image_0" accept="image/*" />
                </div>
                <div class="error_show error_branches.0.opening_certificate_image"> </div>

                <div class="uploaded__area" id="filesNext_image_0_cont"></div>
            </div>



            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">@lang('localize.lab_open_certificate_pdf')</h6>
                <div class="form__label ">
                    <label for="filesNext_pdf_0_input" class="apload-img-reg">
                        <div class="add-photo">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <div class="img-apload-title">
                            @lang('localize.lab_open_certificate_pdf')
                        </div>
                    </label>
                    <input type="file" onchange="abloadDefi(this)" hidden id="filesNext_pdf_0_input"
                        class="heddenUploud files-input" data-single="true"
                        name="branches[0][opening_certificate_pdf]" data-input="filesNext_pdf_0" accept=".pdf" />
                </div>
                <div class="error_show error_branches.0.opening_certificate_pdf"> </div>

                <div class="uploaded__area" id="filesNext_pdf_0_cont"></div>
            </div>
        </div>

        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">
                @lang('localize.lab_images')
            </h6>
            <div class="form__label">
                <label for="filesNext4_input" class="apload-img-reg">
                    <input type="file" hidden multiple id="filesNext4_input" class="heddenUploud files-input"
                        onchange="abloadDefi(this)" name="branches[0][images][]" data-input="filesNext4"
                        accept="image/*" />
                    <div class="add-photo">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <div class="img-apload-title">
                        @lang('localize.pe_clinic_images')
                    </div>
                </label>
            </div>
            <div class="uploaded__area" id="filesNext4_cont"></div>
            <div class="error_show error_branches.0.images"> </div>
        </div>

        <div class="work-date-container form-section-style main-inp-cont">
            <h6 class="fontBold mainColor font14">
                @lang('localize.working_times')
            </h6>

            <div class="work-date-content">
                <div class="work-parent2 row g-0">
                    <div class="work-date times-cont col-md-12">
                        <div class="row g-2">
                            <div class="input-work col-6 col-sm-6 col-md-4">
                                <div class="input-icon">
                                    <select name="branches[0][dates][0][day]" class="default_input">
                                        <option value="saturday">@lang('localize.sat')</option>
                                        <option value="sunday">@lang('localize.sun')</option>
                                        <option value="monday">@lang('localize.mon')</option>
                                        <option value="tuesday">@lang('localize.tue')</option>
                                        <option value="wednesday">@lang('localize.wen')</option>
                                        <option value="thursday">@lang('localize.thu')</option>
                                        <option value="friday">@lang('localize.fri')</option>
                                    </select>
                                    <div class="error_show error_branches.0.dates.0.day"> </div>
                                </div>
                            </div>
                            <div class="input-work col-6 col-sm-6 col-md-4">
                                <input type="text" name="branches[0][dates][0][from]"
                                    placeholder="@lang('localize.from')" class="from-date" id="" />
                                <label class="add-photo" for="time1">
                                    <i class="fa-regular fa-clock"></i>
                                </label>
                                <div class="error_show error_branches.0.dates.0.from"> </div>
                            </div>
                            <div class="input-work col-6 col-sm-6 col-md-4">
                                <input type="text" name="branches[0][dates][0][to]"
                                    placeholder="@lang('localize.to')" class="to-date" id="" />
                                <label class="add-photo" for="time2">
                                    <i class="fa-regular fa-clock"></i>
                                </label>
                                <div class="error_show error_branches.0.dates.0.to"> </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="work-plus-icon22" onclick="appendDateMain(this ,0)">
                    <div class="plus-add">@lang('localize.add_new')</div>
                </div>

                <div class="error_show error_branches.0.dates"> </div>
            </div>
        </div>
    </div>
    <button onclick="appendAll()" class="dafult-blue-btn up" type="button">
        @lang('localize.add_new_ranch')
    </button>
    <!-- </form> -->
    <ul class="list-inline">
        <button type="button" class="default-btn next-step up">
            @lang('localize.next')
        </button>
    </ul>
</div>
