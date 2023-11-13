<div class="tab-pane" role="tabpanel" id="step4">
    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">@lang('localize.password')</h6>
        <div class="form__label">
            <input class="default_input" type="password" name="password" placeholder=" @lang('localize.pe_password')" />
            <label class="float__label" for="">@lang('localize.pe_password')</label>
        </div>
        <div class="error_show error_password"> </div>
    </div>
    <div class="mb-3 main-inp-cont">
        <h6 class="fontBold mainColor font14">
            @lang('localize.password_confirmation')
        </h6>
        <div class="form__label">
            <input class="default_input" type="password" name="password_confirmation" placeholder=" @lang('localize.pc_password')" />
            <label class="float__label" for="">@lang('localize.pc_password')</label>
        </div>
        <div class="error_show error_password_confirmation"> </div>
    </div>

    <ul class="list-inline pull-right">
        <button type="submit" id="submit-button" class="default-btn next-step up submit-button">
            @lang('localize.create_account')
        </button>
    </ul>
</div>
