<form action="{{ route('pharmacy.orders.make') }}" data-success="$('#staticBackdrop').modal('show')" class="form"
    method="POST">
    @csrf

    <input type="hidden" name="store_id" value="{{ $store->id }}">
    <div class="modal-body no-border-bottom modal2-spe">
        <h5 class="font_bold text-center mb-3">@lang('localize.checkout')</h5>

        <div class="make_order_modal_header">
            @include('providers_dashboards.pharmacy.cart._make_order_modal_header')
        </div>

        {{--  <div class="grid-cart">
                <div class="mb-3 main-inp-cont">
                    <h6 class="fontBold mainColor font14">
                        العنوان
                    </h6>
                    <div class="form__label">
                        <input class="default_input" type="text"
                            placeholder="الرجاء ادخال عنوان التوصيل" id="inputMap" data-toggle="modal"
                            data-target="#mapModal" />
                        <label class="float__label" for="">الرجاء ادخال عنوان التوصيل</label>
                        <div class="add-photo">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                </div>
              
            </div>  --}}

        <input type="hidden" name="store_id" value="{{ $store->id }}">

        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14"> @lang('localize.pharmacy_branch') </h6>
            <div class="form__label">
                <select name="pharmacy_branch_id" class=" main_speciality default_input">
                    <option selected disabled>{{ __('admin.select') . ' ' . __('localize.pharmacy_branch') }}</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>

            </div>
            <div class="error_show error_pharmacy_branch_id"> </div>
        </div>

        <div class="mb-3 main-inp-cont">
            <div class="maps">
                <div class="mb-3 main-inp-cont">
                    <h6 class="fontBold mainColor font14">
                        @lang('localize.delivery_address')
                    </h6>
                    <div class="form__label">
                        <input type="hidden" name="deliver_lat" class="lat" value="31.04035945880287">
                        <input type="hidden" name="deliver_lng" class="lng" value="31.37892723083496">
                        <input class="default_input address" name="address" readonly type="text"
                            placeholder="@lang('localize.pe_delivery+address')" />
                        <label class="float__label" for="">@lang('localize.pe_delivery+address')</label>
                        <div class="add-photo">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                </div>
                <div id="" style="width: 100%; height: 320px" class="mb-3 map"></div>
            </div>
            <div class="error_show error_deliver_lat"> </div>
            <div class="error_show error_deliver_lng"> </div>
            <div class="error_show error_branches.address"> </div>
        </div>


        <div class="ather-big">
            <h6 class="fontBold mainColor font14">@lang('localize.Receiving_method')</h6>

            <div class="ather-right">
                <input type="radio" class="dafault-radio radio-spe2" name="receiving_method" id="same1"
                    value="by_delegate" />
                <label for="same1" class="radio-text">@lang('localize.by_delegate')</label>
            </div>
            <div class="ather-left">
                <input id="same2" type="radio" class="dafault-radio radio-spe2" name="receiving_method"
                    value="on_arrival" />
                <label for="same2" class="radio-text">@lang('localize.on_arrival')</label>
            </div>
        </div>
        <div class="error_show error_receiving_method"> </div>

        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">@lang('localize.payment_method')</h6>
            <div class="flex-cart mb-3">
                <div class="inp-g-cart">
                    <input checked type="radio" id="ch1" name="payment_type" value="cash" class="radio-spe">
                    <label for="ch1">@lang('localize.cache')</label>
                </div>
                <div class="inp-g-cart">
                    <input type="radio" id="ch2" name="payment_type" value="installment" class="radio-spe">
                    <label for="ch2">@lang('localize.installment')</label>
                </div>
                <div class="inp-g-cart">
                    <input type="radio" id="ch3" name="payment_type" value="online" class="radio-spe">
                    <label for="ch3">@lang('localize.online')</label>
                </div>
            </div>
            <div class="error_show error_payment_method"> </div>

        </div>


        <div class="mb-3 payment_type installment main-inp-cont33" style="display: none">
            <h6 class="fontBold mainColor font14">@lang('localize.payment_period_in_days')</h6>
            <div class="form__label">
                <input class="default_input" type="text" name="installment_days" placeholder="@lang('localize.pe_payment_period_in_days')" />
                <label class="float__label" for="">@lang('localize.pe_payment_period_in_days')</label>
            </div>
            <div class="error_show error_installment_days"> </div>

        </div>
        <div class="mb-3 payment_type installment main-inp-cont33" style="display: none">
            <h6 class="fontBold mainColor font14">@lang('localize.installment_number')</h6>
            <div class="form__label">
                <input class="default_input" type="text" name="installment_number"
                    placeholder="@lang('localize.pe_installment_number')" />
                <label class="float__label" for="">@lang('localize.pe_installment_number')</label>
            </div>
            <div class="error_show error_installment_number"> </div>

        </div>

        {{-- <div class="mb-3 main-inp-cont3 div3">
                <h6 class="fontBold mainColor font14">وسيلة الدفع</h6>
                <select name="" id="" class="default2-select gr">
                    <option value="" selected disabled>يرجى اختيار الفترة المراد التسديد فيها
                    </option>
                    <option value="">المحفظة</option>
                    <option value="">الجوال</option>
                </select>
            </div> --}}
        <div class="mb-3 main-inp-cont33">
            <h6 class="fontBold mainColor font14">@lang('localize.delivery_notes')</h6>
            <div class="form__label">
                <input name="notes" class="default_input" type="text" placeholder="@lang('localize.pe_delivery_notes')" />
                <label class="float__label" for="">@lang('localize.pe_delivery_notes')</label>
            </div>
            <div class="error_show error_delivery_notes"> </div>

        </div>

        <div class="">
        </div>
        <div class="flex-card-2 mb-3 make_order_modal_footer">
            @include('providers_dashboards.pharmacy.cart._make_order_modal_footer')
        </div>

        <button class="submit submit-button up wid-70">@lang('localize.confirm_order')</button>

    </div>
</form>
