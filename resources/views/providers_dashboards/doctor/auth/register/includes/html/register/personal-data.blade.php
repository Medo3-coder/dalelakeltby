<div class="tab-pane active" role="tabpanel" id="step1">
    <div class="img-regester-cont identity_image">
        <label for="img-up" class="img-edit">
            <input onchange="loadFiles(event)" name="image" type="file" id="img-up" hidden accept="image/*" />
            <i class="fa-regular fa-pen-to-square"></i>
        </label>
        <img id="change-profile" src="{{ asset('/site') }}/imgs/NoPath.png" alt="" />
        <div class="error_show error_image"> </div>

    </div>

    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">@lang('localize.doctor_name')</h6>
        <div class="form__label">
            <input class="default_input" name="name" type="text" placeholder="@lang('localize.please_enter_dr_name')" />
            <label class="float__label" for="">@lang('localize.please_enter_dr_name')</label>
        </div>
        <div class="error_show error_name"> </div>
    </div>

    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">@lang('localize.address')</h6>
        <div class="form__label">
            <input class="default_input" name="address" type="text" placeholder="@lang('localize.pe_address')" />
            <label class="float__label" for="">@lang('localize.pe_address')</label>
        </div>
        <div class="error_show error_address"> </div>
    </div>

    <div class="mb-3">
        <h6 class="fontBold mainColor font14">@lang('localize.dr_name_choosable')</h6>
        <div class="form__label">
            <input class="default_input" name="nickname" type="text" placeholder="@lang('localize.please_enter_dr_nik_name')" />
            <label class="float__label" for="">@lang('localize.please_enter_dr_nik_name')</label>
        </div>
        <div class="error_show error_nickname"> </div>
    </div>

    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">
            @lang('localize.city')
        </h6>
        <div class="form__label">
            <select name="city_id" class="  default_input">
                <option selected disabled>@lang('localize.city')</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="error_show error_city_id"> </div>

    </div>

    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">@lang('localize.age')</h6>
        <div class="form__label">
            <input class="default_input" name="age" type="number" placeholder="@lang('localize.pe_age')" />
            <label class="float__label" for="">@lang('localize.pe_age')</label>
        </div>
        <div class="error_show error_age"> </div>
    </div>

    <div class="input-g input-group-full age-date inp-cont-spe mb-3">
        <label class="special-tele" for="">@lang('localize.phone_number')</label>
        <input type="hidden" id="country_code" name="country_code">
        <input type="tel" name="phone" id="telephone" placeholder="@lang('localize.please_enter_phone_number')" class="inp-spe" />
        <div class="error_show error_country_code"> </div>
        <div class="error_show error_phone"> </div>
    </div>
    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">
            @lang('localize.elect_mail')
        </h6>
        <div class="form__label">
            <input class="default_input" name="email" type="email" placeholder=" @lang('localize.please_enter_ele_email')" />
            <label class="float__label" for="">@lang('localize.please_enter_ele_email')</label>
        </div>
        <div class="error_show error_email"> </div>
    </div>
    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">
            @lang('localize.main_speciality')
        </h6>
        <div class="form__label">
            <select name="category_id" class=" main_speciality default_input">
                <option selected disabled>@lang('localize.pc_main_speciality')</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3 sub_speciality main-inp-cont"></div>
    <div class="error_show error_category_id"> </div>

    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">@lang('localize.qualification')</h6>
        <div class="form__label">
            <input class="default_input" name="qualifications" type="text" placeholder="@lang('localize.pe_qualification')" />
            <label class="float__label" for="">@lang('localize.pe_qualification')</label>
        </div>
        <div class="error_show error_qualifications"> </div>
    </div>
    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">@lang('doctor.abstract')</h6>
        <div class="form__label">
            <input class="default_input" name="abstract" type="text" placeholder="@lang('doctor.abstract')" />
            <label class="float__label" for="">@lang('doctor.abstract')</label>
        </div>
        <div class="error_show error_abstract"> </div>
    </div>

    <div class="groups-inp">
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">@lang('localize.identity_number')</h6>
            <div class="form__label ">
                <input class="default_input" name="identity_number" type="number"
                    placeholder="@lang('localize.enter_identity_number')" />
                <label class="float__label" for="">@lang('localize.enter_identity_number')</label>
            </div>
            <div class="error_show error_identity_number"> </div>
        </div>
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">@lang('localize.identity_image')</h6>
            <div class="form__label ">
                <label for="filesNext_input" class="apload-img-reg">
                    <div class="add-photo">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <div class="img-apload-title">
                        @lang('localize.please_enter_identity_image')
                    </div>
                </label>
                <input type="file" onchange="abloadDefi(this)" hidden id="filesNext_input"
                    class="heddenUploud files-input" data-single="true" name="identity_image" data-input="filesNext"
                    accept="image/*" />
            </div>
            <div class="error_show error_identity_image"> </div>
            <div class="uploaded__area" id="filesNext_cont"></div>
        </div>
    </div>
    <!-- </form> -->
    <ul class="list-inline">
        <button type="button" class="default-btn next-step up">
            @lang('localize.next')
        </button>
    </ul>
</div>
