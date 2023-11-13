<link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
    integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
</script>

<script>
    let buttontext = $('#submit-button').html();
    $(document).ready(function() {
        $(document).on('submit', '.form', function(e) {
            var old_content = $(".submit-button").html();

            var timesCont = $('.times-cont');
            var check = true;

            if (timesCont.length > 0) {

                $('.msg-error').remove();
                timesCont.each(function(key, value) {
                    var from = $(this).find('.from-date');
                    var to = $(this).find('.to-date');
                    var msg = '';
                    if (from.val() == '') {
                        msg += 'يجب اختيار اوقات العمل من , ';
                    }

                    if (Date.parse('01/01/2011 ' + from.val()) > Date.parse('01/01/2011 ' + to
                            .val())) {

                        msg += 'توقيت النهاية يجب اني يكون اكبر من البداية , ';
                    }

                    if (to.val() == '') {

                        msg += 'يجب اختيار اوقات العمل الى , ';
                    }
                    if (msg != '') {
                        check = false;
                        $('[aria-controls="' + 'step2' + '"]').click();
                        $(this).append(`
                        <div class="alert alert-danger text-center msg-error">${msg}</div>
                    `)
                    }


                });

            }

            e.preventDefault();
            if (check == true) {
                var url = $(this).attr('action')
                $(this).ajaxSubmit({
                    url: url,
                    beforeSend: function() {
                        old_content = $(".submit-button").html();
                        var submitForm = $("#submit-button");
                        submitForm.attr('disabled', true)
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        $("#submit-button").text(percentComplete + '%');
                    },
                    success: (response) => {
                        $(".error_show").html('')
                        $('.form input , .form select , .form textarea').removeClass(
                            'border-danger')
                        $(".submit-button").html(old_content).attr('disabled', false)
                        if (response.status != 'success') {
                            if (response.hasOwnProperty('input')) {
                                $('.form .error_' + response.input).append(
                                    `<span class="mt-5 text-danger">${response.msg}</span>`
                                );
                                $('.form input[name^=' + response.input + ']' +
                                        '.form select[name^=' + response.input + ']' +
                                        '.form textarea[name^=' + response.input + ']')
                                    .addClass('border-danger')
                            } else {
                                toastr.error(response.msg)
                            }
                        } else {
                            $('#searchMODEL').trigger('focus');
                            toastr.success(response.msg);
                        }

                        if (response.hasOwnProperty('url')) {
                            setTimeout(function() {
                                window.location.replace(response.url)
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        $('#submit-button').html(buttontext).removeAttr('disabled');
                        $('.text-danger').remove();
                        var firstValidation = Object.keys(xhr.responseJSON.errors)[0];

                        // go to first error step 
                        if (firstValidation.indexOf(".") >= 0) {
                            var split = firstValidation.split('.');
                            firstValidation = split[0];
                            for (let index = 1; index < split.length; index++) {
                                firstValidation += '[' + split[index] + ']';
                            }
                        }

                        var attr = $('[name="' + firstValidation + '"]');
                        var dataName = $('[data-name="' + firstValidation + '"]')
                        var id;
                        if (attr.length > 0) {
                            id = attr.parents('.tab-pane').attr('id');
                            $('[aria-controls="' + id + '"]').click();
                        }

                        if (dataName.length > 0) {
                            id = dataName.parents('.tab-pane').attr('id');
                            $('[aria-controls="' + id + '"]').click();
                        }

                        $(".error_show").html('')
                        $('.form input , .form select , .form textarea').removeClass(
                            'border-danger')
                        $(".submit-button").html(old_content).attr('disabled', false)

                        $.each(xhr.responseJSON.errors, function(key, value) {

                            let input_key = key;
                            let error_key = key;
                            if (key.indexOf(".") >= 0) {
                                var split = key.split('.');
                                input_key = split[0];
                                error_key = split[0]
                                for (let index = 1; index < split.length; index++) {
                                    input_key += '[' + split[index] + ']';
                                    error_key += '\\.' + split[index];
                                }
                            }

                            $('[name^="' + input_key + '"]').addClass(
                                'border-danger');

                            $('.form .error_' + error_key).append(
                                `<span class="mt-5 text-danger">${value}</span>`
                            );

                        });
                    },
                });
            }
        });
    });
</script>
<script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
