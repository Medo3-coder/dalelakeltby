<div class="tab-pane active" role="tabpanel" id="step1">
    <div class="img-regester-cont identity_image" >
        <label for="img-up" class="img-edit">
            <input onchange="loadFiles(event)" name="image" type="file" id="img-up" hidden accept="image/*" />
            <i class="fa-regular fa-pen-to-square"></i>
        </label>
        <img id="change-profile" src="{{ asset('/site') }}/imgs/NoPath.png" alt="" />
        <div class="error_show error_image"> </div>

    </div>

    <!-- <form action="#"> -->
    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">{{ __('store.the owner\'s name') }}</h6>
        <div class="form__label">
            <input class="default_input" name="name" type="text"  placeholder="{{ __('store.Please enter the name of the owner') }}" />
            <label class="float__label" for="">{{ __('store.Please enter the name of the owner') }}</label>
        </div>
        <div class="error_show error_name"> </div>
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
            {{ __('store.email') }}
        </h6>
        <div class="form__label">
            <input class="default_input" name="email" type="email"  placeholder=" {{ __('store.Please enter e-mail') }}" />
            <label class="float__label" for="">{{ __('store.Please enter e-mail') }}</label>
        </div>
        <div class="error_show error_email"> </div>
    </div>
    <div class="groups-inp">
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">{{ __('store.ID Number_val') }}</h6>
            <div class="form__label ">
                <input class="default_input" name="identity_number" type="number"  placeholder="{{ __('store.Please enter the ID number') }}" />
                <label class="float__label" for="">{{ __('store.Please enter the ID number') }}</label>
            </div>
            <div class="error_show error_identity_number"> </div>
        </div>
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">{{ __('store.Delivery price') }}</h6>
            <div class="form__label ">
                <input class="default_input" name="delivery_price" type="number"  placeholder="{{ __('store.Delivery price val') }}" />
                <label class="float__label" for="">{{ __('store.Delivery price val') }}</label>
            </div>
            <div class="error_show error_delivery_price"> </div>
        </div>
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">{{ __('store.ID photo') }}</h6>
            <div class="form__label ">
                <label for="filesNext_input" class="apload-img-reg">
                    <div class="add-photo">
                        <i class="fa-solid fa-images"></i>
                    </div>
                    <div class="img-apload-title">
                        {{ __('store.Please enter a photo ID') }}
                    </div>
                </label>
                <input type="file" hidden id="filesNext_input" class="heddenUploud files-input" data-single="true" name="identity_image" data-input="filesNext" accept="image/*" />
            </div>
            <div class="error_show error_identity_image"> </div>
            <div class="uploaded__area" id="filesNext_cont"></div>
        </div>
    </div>
    <!-- </form> -->
    <ul class="list-inline">
        <button type="button" class="default-btn next-step up">
            {{ __('store.the next') }}
        </button>
    </ul>
</div>
