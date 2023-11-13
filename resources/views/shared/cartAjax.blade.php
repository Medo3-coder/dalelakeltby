    <!-- Modal 2 -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="">
                    <div class="font_bold don-t">@lang('localize.added_to_cart') </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">تم</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on('click', '[data-add-cart-url]', function() {
            let addUrl = $(this).data('add-cart-url');
            let addBtn = $(this);
            $.ajax({
                url: addUrl,
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    qty: $(this).data('qty') ?? 1
                },
                dataType: 'json',
                success: (response) => {
                    if (response.status != 'success') {
                        toastr.error(response.msg)
                    } else {
                        $('#staticBackdrop').modal('show');
                        increaseCart();
                        $(this).html('<i class="fa fa-check"></i>').attr('data-add-cart-url', '').attr(
                            'disabled', true);
                        $(addBtn).parent().parent().find('.qty').remove();
                    }
                },
            });
        });

        function increaseCart() {
            const navCounter = $('#nav_cart_counter');
            navCounter.html(parseInt(navCounter.html()) + 1);
        }

        function decreaseCart() {
            const navCounter = $('#nav_cart_counter');
            navCounter.html(parseInt(navCounter.html()) - 1);
        }
    </script>
