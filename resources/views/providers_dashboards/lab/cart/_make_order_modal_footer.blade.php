<div class="rright">@lang('localize.price') <span>{{ $total_price }} @lang('site.currency')</span></div>
@if (isset($coupon) && isset($discount))
    <div class="rright">@lang('localize.coupon_discount'): <span>{{ $discount }} @lang('site.currency')</span></div>
@endif
<div class="rright">@lang('localize.total_price'): <span>{{ $final_total }} @lang('site.currency')</span></div>
