@extends('providers_dashboards.layouts.dashboards.master')


@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading mt-4">
                <h6>@lang('localize.cart')</h6>
                <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('lab')->user()->name])</p>
            </div>
            <div class="devices-boxs">
                <div class="row">

                    @forelse ($carts as $store_id => $storeCarts)
                        <div wire:key="cart_{{ $store_id }}" class="col-lg-4 col-md-6 col-12">
                            {{-- {{$store}} --}}
                            <div class="device-box">
                                <img src="{{ $storeCarts->first()->offer->image ?? $storeCarts->first()->store->image }}"
                                    alt="">
                                <div class="card_foot card-f-spe">
                                    <h6 class="text-center font_bold">{{ $storeCarts->first()->store->name }}</h6>
                                    <div class="flex-device white-fire">

                                        @php
                                            $price = 0;
                                            $storeCarts->each(function ($cart) use (&$price) {
                                                $price += $cart->price;
                                            });
                                        @endphp
                                        <div class="right-device">@lang('localize.price')
                                            {{ $price }}
                                            @lang('site.currency')</div>
                                        {{--  <div class="left-device">كوبون الخصم: ABC</div>  --}}
                                    </div>
                                    <div class="flex-device white-fire">
                                        @php
                                            $discount = 0;
                                            $storeCarts->each(function ($cart) use (&$discount) {
                                                $discount += $cart->discount;
                                            });
                                        @endphp
                                        <div class="right-device">@lang('localize.discount')
                                            {{ $discount }}
                                            @lang('site.currency')</div>
                                    </div>
                                    <div class="flex-device justify-content-center">

                                        <a href="#" class="link-device up makeOrderGetData"
                                            data-url="{{ route('lab.cart.makeOrderGetData', $store_id) }}"
                                            data-toggle="modal" data-target="#exampleModal3"
                                            data-dismiss="modal">@lang('localize.done_payment')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        @include('shared.empity')
                    @endforelse

                </div>
            </div>
    </main>

    <!-- Modal 2 -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="../lab dashboard/imgs/7717-successful.gif" alt="">
                    <div class="font_bold don-t">تم عمل الطلبية بنجاح </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">تم</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModal3Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe">
            <div class="modal-content" id="makeOrderBody">

            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('shared.formAjax')

    <script>
        $(document).on('click', '.makeOrderGetData', function() {
            var url = $(this).data('url')
            $.ajax({
                url: url,
                method: 'get',
                data: {},
                dataType: 'json',
                success: (response) => {

                    if (response.status == 'success') {
                        $('#makeOrderBody').html(response.html);
                        $('#exampleModal3').modal('show');

                        var map = $('.map');
                        var lat = $('.lat')
                        var lng = $('.lng')
                        var address = $('.address')

                        mapLocation(map, lat, lng, address);
                    } else {
                        toastr.error(response.msg)
                    }

                },
            });
        });

        $(document).on('click', '[data-change-cart]', function() {
            var url = "{{ route('lab.cart.change') }}"
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    operation: $(this).data('change-cart'), // increment ,decrement ,remove
                    cart: $(this).data('cart'),
                },
                dataType: 'json',
                success: (response) => {

                    if (response.status == 'success') {
                        $('.make_order_modal_header').html(response.header);
                        $('.make_order_modal_footer').html(response.footer);
                    } else {
                        toastr.error(response.msg)
                    }
                },
            });
        });



        $(document).on('click', '.check-coupon', function() {
            var url = "{{ route('lab.cart.saveCoupon') }}";
            let old_content;
            const btn = $(this)
            if ($('input[name="coupon"]').val()) {
                $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon: $('input[name="coupon"]').val(),
                        cart: $(this).data('cart'),
                        store: $(this).data('store'),
                    },
                    beforeSend: () => {
                        old_content = $(this).html();
                        btn.html(
                            '<div class="w-100 d-flex justify-content-center text-center"><div class="submit-loader"></div></div>'
                        );
                        btn.attr("disabled", 'disabled');
                    },
                    dataType: 'json',
                    success: (response) => {
                        btn.html(old_content).removeAttr('disabled');
                        if (response.status == 'success') {

                            toastr.success(response.msg);

                            $('.make_order_modal_header').html(response.header);
                            $('.make_order_modal_footer').html(response.footer);

                        } else {
                            toastr.error(response.msg)

                        }
                    },
                    error: () => {
                        btn.html(old_content).removeAttr('disabled');
                    }
                });
            }
        });

        $(document).on('click', '.delete-coupon', function() {
            var url = "{{ route('lab.cart.deleteCoupon') }}";
            let old_content;
            const btn = $(this)
            $.ajax({
                url: url,
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    coupon: $('input[name="coupon"]').val(),
                    cart: $(this).data('cart'),
                    store: $(this).data('store'),
                },
                beforeSend: () => {
                    old_content = $(this).html();
                    btn.html(
                        '<div class="w-100 d-flex justify-content-center text-center"><div class="submit-loader"></div></div>'
                    );
                    btn.attr("disabled", 'disabled');
                },
                dataType: 'json',
                success: (response) => {
                    btn.html(old_content).removeAttr('disabled');
                    if (response.status == 'success') {

                        toastr.success(response.msg);

                        $('.make_order_modal_header').html(response.header);
                        $('.make_order_modal_footer').html(response.footer);

                    } else {
                        toastr.error(response.msg)
                    }
                },
                error: () => {
                    btn.html(old_content).removeAttr('disabled');
                }
            });
        });
    </script>



    <script>
        $(document).on('change', ".radio-spe", function() {
            $(".payment_type").hide();
            if (this.value == "show1") {
                $(".div3").hide();
            } else if (this.value == "installment") {
                $(".installment").show();
            } else if (this.value == "show3") {
                $(".div3").show();
            }
        });
    </script>


    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBn3NtsJ5lgHSIxUJ4AuqAMm2RXldDDjN8&libraries=places&language=ar">
    </script>
    <script src="{{ asset('dashboard/js/location-picker.js') }}"></script>


    <script>
        function mapLocation(map, lat, lng, address) {
            $(map).locationpicker({
                inputBinding: {
                    latitudeInput: $(lat),
                    longitudeInput: $(lng),
                    locationNameInput: $(address),
                    enableAutocomplete: true,
                },

                location: {
                    latitude: $(lat).val(),
                    longitude: $(lng).val()
                },

            });
            navigator.geolocation.getCurrentPosition(function(position) {
                $(map).locationpicker('location', {
                    latitude: position.coords.latitude,
                    longitude: position.coords.longitude,
                    inputBinding: {
                        latitudeInput: $(lat),
                        longitudeInput: $(lng),
                        locationNameInput: $(address)
                    },
                });
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $(".count").prop("disabled", true);
            $(document).on("click", ".plus", function() {
                var count = $(this).closest(".qty").find(".count");
                $(count).val(parseInt($(count).val()) + 1);
            });
            $(document).on("click", ".minus", function() {
                var count = $(this).closest(".qty").find(".count");
                $(count).val(parseInt($(count).val()) - 1);
                if ($(count).val() == 0) {
                    $(count).val(1);
                }
            });
        });
    </script>
@endpush
