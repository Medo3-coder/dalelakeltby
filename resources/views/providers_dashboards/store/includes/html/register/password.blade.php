<div class="tab-pane" role="tabpanel" id="step4">
    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">{{ __('store.password') }}</h6>
        <div class="form__label">
            <input class="default_input" type="password" name="password" placeholder=" {{ __('store.password_val') }}" />
            <label class="float__label" for="">{{ __('store.password_val') }}</label>
        </div>
        <div class="error_show error_password"> </div>
    </div>
    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">
{{ __('store.password_confirmed') }}
        </h6>
        <div class="form__label">
            <input class="default_input" type="password" name="password_confirmation" placeholder=" {{ __('store.password_confirmed_val') }}" />
            <label class="float__label" for="">{{ __('store.password_confirmed_val') }}</label>
        </div>
        <div class="error_show error_password_confirmation"> </div>
    </div>

    <ul class="list-inline pull-right">
        <button type="submit" id="submit-button" class="default-btn next-step up submit-button">
            {{ __('store.Create an account') }}
        </button>
    </ul>
</div>
