<link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
<script>
    $(document).ready(function() {
        $(document).on('submit', '.form', function(e) {
            var old_content = $(this).find(".submit-button").html()
            e.preventDefault();
            var url = $(this).attr('action')
            $.ajax({
                url: url,
                method: 'post',
                data: new FormData($(this)[0]),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: () => {
                    old_content = $(this).find(".submit-button").html()
                    $(this).find(".submit-button").html(
                        '<div class="w-100 d-flex justify-content-center text-center"><div class="submit-loader"></div></div>'
                    ).attr('disabled', true)
                },
                success: (response) => {
                    $(".error_show").html('')
                    $('.form input , .form select , .form textarea').removeClass(
                        'border-danger')
                    $(this).find(".submit-button").html(old_content).attr('disabled', false)
                    if (response.status != 'success') {
                        if (response.hasOwnProperty('input')) {
                            $('.form .error_' + response.input).append(
                                `<span class="mt-5 text-danger">${response.msg}</span>`);
                            $('.form input[name^=' + response.input + ']' +
                                    '.form select[name^=' + response.input + ']' +
                                    '.form textarea[name^=' + response.input + ']')
                                .addClass('border-danger')
                        } else {
                            toastr.error(response.msg)
                        }
                    } else {
                        toastr.success(response.msg);

                        window.response = response;

                        if ($(this).data('success')) {
                            {{--  window[$(this).data('success')](this);
                            window['addPerciptionSuccess'](this);  --}}
                            var tmpFunc = new Function($(this).data('success'));
                            tmpFunc();
                        }
                    }

                    if (response.hasOwnProperty('url')) {
                        setTimeout(function() {
                            window.location.replace(response.url)
                        }, 1000);
                    }
                },
                error: (xhr) => {
                    $(".error_show").html('')
                    $('.form input , .form select , .form textarea').removeClass(
                        'border-danger')
                    $(this).find(".submit-button").html(old_content).attr('disabled', false)

                    $.each(xhr.responseJSON.errors, function(key, value) {
                        if ($('.form .error_' + key.split('.').join('\\.'))[0]) {
                            $('.form .error_' + key.split('.').join('\\.')).append(
                                `<span class="mt-5 text-danger">${value}</span>`
                            );
                            // console.log($('.form .error_' + key)[0])
                        } else {
                            if (key.indexOf(".") >= 0) {
                                var split = key.split('.')
                                key = split[0] + '\\[' + split[1] + '\\]'
                            }

                            $('.form .error_' + key).append(
                                `<span class="mt-5 text-danger">${value}</span>`
                            );
                            $('.form input[name^=' + key + ']' +
                                    '.form select[name^=' +
                                    key + ']' + '.form textarea[name^=' + key + ']')
                                .addClass('border-danger')
                        }

                    });
                },
            });

        });
    });
</script>
<script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
