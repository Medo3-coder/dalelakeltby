@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />

    <style>
        .wid-spe-50{
            width: 110px;
            color: red;
        }
    </style>
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="card-white spe-pad">
                @forelse($products as $product)
                    @if($product->category_type == 'equipment')
                        <div class="box-for-product mb-3">
                            <div class="box-for-product-right">
                                <img src="{{ $product->image }}" alt="" />
                            </div>
                            <div class="box-for-product-left">
                                <div class="box-for-product-left-f-top mb-3">
                                    <h6 class="font-bold no-border-bottom padding-btm-no">
                                        {{ $product->name }}
                                    </h6>
                                    <div class="center-flex">
                                        <div class="line-spe-div">@lang('localize.available_qty') :
                                            {{ $product->groupOne()->in_stock_qty }} @lang('localize.packet')</div>
                                        <div class="line-spe-div">@lang('localize.price') : {{ $product->price }} @lang('site.currency')
                                        </div>
                                    </div>
                                    @if($product->groupOne()->in_stock_qty > 0)
                                        @if (
                                            $notInCart = !in_array(
                                                $product->id,
                                                provider(request()->segment(1))->cartProductOffers()->pluck('product_id')->toArray()))
                                            <a href="#" data-qty="1"
                                               data-add-cart-url="{{ route('pharmacy.cart.addProduct', $product->id) }}"
                                               class="color-main "><i class="fa-solid fa-cart-plus"></i>
                                                @lang('localize.add_to_cart')</a>
                                        @else
                                            <button class="btn" style="color:#000!important">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @endif
                                    @else
                                        <div class="wid-spe-50">{{ __('translation.quantity_not_available') }}</div>
                                    @endif
                                </div>
                                <div class="par-code">{{ $product->product_num }}</div>
                                <div class="all-spans">
                                    <span>{{ __('store.Type') }} :</span>
                                    <span>( {{ __('store.equipment') }} )</span>
                                </div>
                                <div class="decive-job">
                                    <span class="hegh-span"> {{ __('store.About the device') }}:</span>
                                    <p class="color-gray">
                                    {{ $product->desc }}
                                </div>

                                <div class="box-for-product-left-rr">
                                    <div>@lang('localize.discount') {{ $product->discount }} @lang('site.currency')</div>
                                    @if($product->groupOne()->in_stock_qty > 0)
                                        @if ($notInCart)
                                            <div class="qty counter-div justify-content-center">
                                                <button class="plus counter-btn unselectable">+</button>
                                                <input type="text" value="1" class="count output" disabled="" />
                                                <button class="minus counter-btn unselectable">-</button>
                                            </div>
                                        @endif
                                    @else
                                        <div class="wid-spe-50"></div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @else
                        <div class="box-for-product mb-3">
                            <div class="box-for-product-right">
                                <img src="{{ $product->image }}" alt="" />
                            </div>
                            <div class="box-for-product-left">
                                <div class="box-for-product-left-f-top mb-3">
                                    <h6 class="font-bold no-border-bottom padding-btm-no">
                                        {{ $product->name }}
                                    </h6>
                                    <div class="center-flex">
                                        <div class="line-spe-div">@lang('localize.available_qty') :
                                            {{ $product->groupOne()->in_stock_qty }} @lang('localize.packet')</div>
                                        <div class="line-spe-div">@lang('localize.price') : {{ $product->price }} @lang('site.currency')
                                        </div>
                                    </div>
                                    @if($product->groupOne()->in_stock_qty > 0)
                                        @if (
                                            $notInCart = !in_array(
                                                $product->id,
                                                provider(request()->segment(1))->cartProductOffers()->pluck('product_id')->toArray()))
                                            <a href="#" data-qty="1"
                                               data-add-cart-url="{{ route('pharmacy.cart.addProduct', $product->id) }}"
                                               class="color-main "><i class="fa-solid fa-cart-plus"></i>
                                                @lang('localize.add_to_cart')</a>
                                        @else
                                            <button class="btn" style="color:#000!important">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        @endif
                                    @else
                                        <div class="wid-spe-50">{{ __('translation.quantity_not_available') }}</div>
                                    @endif
                                </div>
                                <div class="par-code">{{ $product->product_num }}</div>
                                <div class="all-spans">
                                    <span>{{ __('store.Type') }} :</span>
                                    <span>( {{ __('store.medicine') }} )</span>
                                </div>
                                <div class="all-spans">
                                    <span>{{ __('store.Active substances') }}:</span>
                                    <span>{{ $product->effective_material }}</span>

                                </div>
                                <div class="decive-job">
                                    <span class="hegh-span"> {{ __('store.medicine description') }}:</span>
                                    <p class="color-gray">
                                        {{ $product->desc }}
                                    </p>
                                </div>

                                <div class="box-for-product-left-rr">
                                    <div>@lang('localize.discount') {{ $product->discount }} @lang('site.currency')</div>
                                    @if($product->groupOne()->in_stock_qty > 0)
                                        @if ($notInCart)
                                            <div class="qty counter-div justify-content-center">
                                                <button class="plus counter-btn unselectable">+</button>
                                                <input type="text" value="1" class="count output" disabled="" />
                                                <button class="minus counter-btn unselectable">-</button>
                                            </div>
                                        @endif
                                    @else
                                        <div class="wid-spe-50"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                    @include('shared.empity')
                @endforelse
            </div>
        </div>
    </main>
@endsection
@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @include('shared.cartAjax')

    <script>
        $(document).ready(function() {

            $(".count").prop("disabled", true);
            let value = 1;
            $(document).on("click", ".plus", function() {
                var count = $(this).closest(".qty").find(".count");
                value = parseInt($(count).val()) + 1;
                $(count).val(parseInt(value));
                $(this).parent().parent().parent().find('[data-qty]').attr('data-qty', value);
            });
            $(document).on("click", ".minus", function() {
                var count = $(this).closest(".qty").find(".count");
                value = parseInt($(count).val()) - 1;
                if (value == 0) {
                    value = 1;
                }
                $(count).val(value);
                $(this).parent().parent().parent().find('[data-qty]').attr('data-qty', value);

            });
        });
    </script>
@endpush


