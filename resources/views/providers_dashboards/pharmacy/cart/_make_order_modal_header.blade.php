<div class="flex-modal-spe">
    <div class="per-name">
        @lang('localize.store__name'): <Span>{{ $store->name }}</Span>
    </div>
    <div class="per-name">
        @lang('localize.delivery_price'): <Span>{{ $store->delivery_price }}</Span>
    </div>
    <div class="per-name">
        @lang('localize.tax_value'): <Span>{{ $vat_amount }}</Span>
    </div>
</div>
<div class="overflowx_auto mb-3 table1-spe mt-5">
    <table class="table text-center" style="width: 100%">
        <thead class="table-head">
            <tr>
                <th class="font10">@lang('localize.desc')</th>
                <th class="font10">@lang('localize.qty')</th>
                <th class="font10">@lang('localize.item_price')</th>
                <th class="font10">@lang('localize.price')</th>
                <th class="font10"></th>
            </tr>
        </thead>
        <tbody data-class-name="table-body">

            @foreach ($carts as $cart)
                <tr>
                    <td class="font12 text-secondary">{{ $cart->name }}</td>

                    <td class="font12 text-secondary">
                        <div class="qty counter-div justify-content-center">
                            <button type="button" data-change-cart="increment" data-cart="{{ $cart->id }}"
                                class="plus counter-btn unselectable">+</button>
                            <input type="text" value="{{ $cart->qty ?? 1 }}" class="count output" disabled="" />
                            <button type="button" data-change-cart="decrement" data-cart="{{ $cart->id }}"
                                class="minus counter-btn unselectable">-</button>
                        </div>
                    </td>

                    <td class="font12">
                        <span class="fontBold text-secondary">{{ $cart->single_price }}
                            @lang('site.currency')</span>
                    </td>

                    <td class="font12">
                        <span class="fontBold text-secondary">{{ $cart->price }}
                            @lang('site.currency')</span>
                    </td>
                    <td>
                        <i class="fa fa-trash deleteProduct" data-value="{{ $cart->id }}"></i>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>

<div class="row align-items-center">
    <div class="col-md-10">
        <div class="mb-3 main-inp-cont">
            <h6 class="fontBold mainColor font14">@lang('localize.coupon')</h6>
            <div class="form__label">
                <input class="default_input" {{ isset($coupon) ? 'value=' . $coupon->coupon : '' }} name="coupon"
                    type="text" placeholder="@lang('localize.pe_coupon')" />
                <label class="float__label" for="">@lang('localize.pe_coupon')</label>
            </div>
        </div>
    </div>
    <div class="col">
        @if (isset($coupon))
            <button data-cart="{{ $cart->id }}" data-store="{{ $store->id }}" type="button"
                class="btn check-coupon mt-2 btn-success">
                {{ __('admin.edit') }}
            </button>
            <button data-cart="{{ $cart->id }}" data-store="{{ $store->id }}" type="button"
                class="btn delete-coupon mt-2 btn-danger">
                <i class="fa fa-trash-alt"></i>
            </button>
        @else
            <button data-cart="{{ $cart->id }}" data-store="{{ $store->id }}" type="button"
                class="btn check-coupon mt-2 btn-success">
                {{ __('admin.save') }}
            </button>
        @endif
    </div>
</div>
