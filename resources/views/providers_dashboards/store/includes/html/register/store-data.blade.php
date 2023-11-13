<div class="tab-pane" role="tabpanel" id="step2">
    <input type="hidden" name="index" value="0">
    <!-- <form action="#"> -->
    <div class="add-append">
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">{{ __('store.store_name') }}</h6>
            <div class="form__label" >
                <input class="default_input" name="name-0"   type="text"  placeholder="{{ __('store.store_name_val') }}" />
                <label class="float__label" for="">{{ __('store.store_name_val') }}</label>
            </div>
            <div class="error_show error_name-0"> </div>
        </div>
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">
                {{ __('store.store_address') }}
            </h6>
            <div class="form__label">
                <input class="default_input" name="address-0" type="text"  placeholder="{{ __('store.store_address_val') }}" />
                <label class="float__label" for="">{{ __('store.store_address_val') }}</label>
            </div>
            <div class="error_show error_address-0"> </div>
        </div>
        <div class="maps">
            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">
                    {{ __('store.store_address_map') }}
                </h6>
                <div class="form__label">
                    <input type="hidden" name="lat-0" class="lat" value="31.04035945880287">
                    <input type="hidden" name="lng-0" class="lng" value="31.37892723083496">
                    <input class="default_input address" name="address_map-0" readonly type="text"  placeholder="{{ __('store.store_address_map_val') }}t" />
                    <label class="float__label" for="">{{ __('store.store_address_map_val') }}</label>
                    <div class="add-photo">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                </div>
            </div>
            <div id="" style="width: 100%; height: 320px" class="mb-3 map"></div>
        </div>



        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">
                {{ __('store.store_record_number') }}
            </h6>

            <div class="form__label">
                <input class="default_input" name="comerical_record-0" type="number"  placeholder=" {{ __('store.store_record_number_val') }}" />
                <label class="float__label" for="">{{ __('store.store_record_number_val') }}</label>
            </div>
            <div class="error_show error_comerical_record-0"> </div>
        </div>
        <div class="groups-inp">
            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">
                    {{ __('store.Repository opening certificate (photo)') }}
                </h6>
                <div class="form__label">
                    <label for="filesNext2_input" class="apload-img-reg">
                        <input type="file" hidden id="filesNext2_input" class="heddenUploud files-input" name="opening_certificate_image-0" data-input="filesNext2" accept="image/*" />
                        <div class="add-photo">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <div class="img-apload-title">
                            {{ __('store.Please enter a copy of the depository opening certificate') }}
                        </div>
                    </label>
                </div>
                <div class="error_show error_opening_certificate_image-0"> </div>
                <div class="uploaded__area" id="filesNext2_cont"></div>
            </div>
            <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">
                    {{ __('store.PDF opening certificate stored') }}
                </h6>
                <div class="form__label">
                    <label for="filesNext3_input" class="apload-img-reg">
                        <input type="file" hidden multiple id="filesNext3_input" class="heddenUploud files-input" name="opening_certificate_pdf-0" data-input="filesNext3" accept="application/pdf" />
                        <div class="add-photo">
                            <i class="fa-solid fa-upload"></i>
                        </div>
                        <div class="img-apload-title">
                            {{ __('store.Please enter a certificate of opening a stockpile') }}
                        </div>
                    </label>
                </div>
                <div class="error_show error_opening_certificate_pdf-0"> </div>
                <div class="uploaded__area" id="filesNext3_cont"></div>
            </div>
        </div>
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">
                {{ __('store.stock image') }}
            </h6>
            <div class="form__label">
                <label for="filesNext4_input" class="apload-img-reg">
                    <input type="file" hidden=""  multiple  id="filesNext4_input" class="heddenUploud files-input" name="images-0[]" data-input="filesNext4" accept="image/*" />
                    <div class="add-photo">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <div class="img-apload-title">
                        {{ __('store.Please enter a photo of the repository') }}
                    </div>
                </label>
            </div>
            <div class="error_show error_images-0"> </div>
            <div class="uploaded__area" id="filesNext4_cont"></div>
        </div>
        <div class="work-date-container form-section-style main-inp-cont">
            <h6 class="fontBold mainColor font14">
                {{ __('store.times of work') }}
            </h6>

            <div class="work-date-content">
                <div class="work-parent2 row g-0">
                    <div class="work-date times-cont col-md-12">
                        <div class="row g-2">
                            <div class="input-work col-6 col-sm-6 col-md-4">
                                <div class="input-icon">
                                    <select name="times[days-0][]" class="default_input">
                                        <option value="saturday">{{ __('store.saturday') }}</option>
                                        <option value="sunday">{{ __('store.sunday') }}</option>
                                        <option value="monday">{{ __('store.monday') }}</option>
                                        <option value="tuesday">{{ __('store.tuesday') }}</option>
                                        <option value="wednesday">{{ __('store.wednesday') }}</option>
                                        <option value="thursday">{{ __('store.thursday') }}</option>
                                        <option value="friday">{{ __('store.friday') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-work col-6 col-sm-6 col-md-4">
                                <input type="text" name="times[from-0][]" placeholder="{{ __('store.from') }}" class="from-date"
                                       id="" />
                                <label class="add-photo" for="time1">
                                    <i class="fa-regular fa-clock"></i>
                                </label>
                            </div>
                            <div class="input-work col-6 col-sm-6 col-md-4">
                                <input type="text" name="times[to-0][]" placeholder="{{ __('store.to') }}" class="to-date"
                                       id="" />
                                <label class="add-photo" for="time2">
                                    <i class="fa-regular fa-clock"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="work-plus-icon22">
                    <div class="plus-add">{{ __('store.add new') }}</div>
                </div>
            </div>
        </div>
    </div>
    <button onclick="appendAll()" class="dafult-blue-btn up" type="button">
        {{ __('store.Add a new branch') }}
    </button>
    <!-- </form> -->
    <ul class="list-inline">
        <button type="button" class="default-btn next-step up">
            {{ __('store.the next') }}
        </button>
    </ul>
</div>
