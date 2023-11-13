<script src="{{ asset('dashboard/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('dashboard/js/wow.min.js') }}"></script>
<script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('dashboard/js/main-dash.js') }}"></script>
<script
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
></script>
<script
        nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
></script>

@stack('js')

@if (session()->has('success'))
    <script>
        toastr.success("{{ session()->get('success') }}")
    </script>
@elseif (session()->has('error'))
    <script>
        toastr.error("{{ session()->get('error') }}")
    </script>
@endif

<script>
    new WOW().init();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
<script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>

<script src="{{ asset('/site/') }}/flag/build/js/intlTelInput.min.js"></script>

<script>
    var input = document.querySelector("#telephone");
    let iti = window.intlTelInput(input, {
        autoPlaceholder: "ادخل",
        customPlaceholder: "kggg",
        initialCountry: "iq",
        // nationalMode:false,
        separateDialCode: true,
    });

    var loadFiles = function(event) {
        var images = document.getElementById("change-profile");
        images.src = URL.createObjectURL(event.target.files[0]);
    };

    $('#country_code').val(iti.getSelectedCountryData()['dialCode'])
</script>
<script>
    let drop = document.querySelector(".upload-search");

    // remove dropDown by clicking on body
    document.body.addEventListener("click", function () {
        $('.my-drop-now').removeClass('show-drop')
    });
    // stop propigation to dropdown
    drop.addEventListener("click", function (e) {
        e.stopPropagation();
    });

    $('.search').on('submit', function (){
        event.preventDefault();
        var form = $(this);
        $(this).ajaxSubmit({
            url: '{{ route(request()->segment(1) .'.search') }}',
            beforeSend: function () {
                var submitForm = $(".search-submit");
                submitForm.attr('disabled', true)
            },

            success: (response) => {
                form.find(".error_show").html('');
                form.find(".search-submit").attr('disabled', false);
                form.find('input').removeClass('border-danger');

                if(response.key == 'success'){
                    $('.upload-search').html(response.html)
                }else {
                    Swal.fire({
                        icon: 'error',
                        iconColor: '#ff0000',
                        title: '<h5 class="font_bold">'+ response.msg +'</h5>',
                        showConfirmButton: true,
                        confirmButtonText: '{{ __('store.ok') }}',

                    })
                }

            },
            error: function (xhr) {
                form.find(".error_show").html('')
                form.find(".search-submit").attr('disabled', false)

                $.each(xhr.responseJSON.errors, function (key, value) {
                    if (key.indexOf(".") >= 0) {
                        var split = key.split('.')
                        key = split[0] + '\\[' + split[1] + '\\]';
                    }

                    form.find('.error_' + key).append(`<span class="text-danger d-block">${value}</span>`);
                    $('[name^=' + key + ']').addClass('border-danger')

                });


            },
        });

    })

</script>


</body>

</html>
