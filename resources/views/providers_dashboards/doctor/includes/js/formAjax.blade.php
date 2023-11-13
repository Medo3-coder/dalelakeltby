
<link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/toastr.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $(document).on('submit', '.form', function() {
            event.preventDefault();

            var form = $(this);

            var old_content =  $(this).find(".submit-button").html();

            var url = $(this).attr('action')
            $(this).ajaxSubmit({
                url: url,
                beforeSend: function () {
                    old_content = $(".submit-button").html();
                    var submitForm = $("#submit-button");
                    submitForm.attr('disabled', true)
                },
                uploadProgress:function (event,position,total,percentComplete) {
                    form.find(".submit-button").attr('disabled', true);
                    form.find(".submit-button").text(percentComplete+'%');
                },
                success: (response) => {
                    $(".error_show").html('')
                    $('.form input , .form select , .form textarea').removeClass('border-danger')
                    form.find(".submit-button").html(old_content).attr('disabled', false)
                    if (response.status != 'success') {
                        if (response.hasOwnProperty('input')) {
                            $('.form .error_' + response.input).append(`<span class="mt-5 text-danger">${response.msg}</span>`);
                            $('.form input[name^=' + response.input + ']' + '.form select[name^=' + response.input + ']' + '.form textarea[name^=' + response.input + ']').addClass('border-danger')
                        } else {
                            Swal.fire({
                                icon: 'error',
                                iconColor: '#ff0000',
                                title: '<h5 class="font_bold">'+ response.msg +'</h5>',
                                showConfirmButton: false,
                                timer: 2000
                            })
                        }
                    } else {
                        Swal.fire({
                            icon: 'success',
                            iconColor: '#2f71b3',
                            title: '<h5 class="font_bold">'+ response.msg +'</h5>',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }

                    if (response.hasOwnProperty('url')) {
                        setTimeout(function () {
                            window.location.replace(response.url)
                        }, 3000);
                    }
                },
                error: function (xhr) {
                    $('.text-danger').remove();
                    $(".error_show").html('')
                    $('.form input , .form select , .form textarea').removeClass('border-danger')
                    form.find(".submit-button").html(old_content).attr('disabled', false)

                    if(xhr.responseJSON != undefined){
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            $('[data-name="' + key + '"]').append(`<span class="text-danger d-block">${value}</span>`);
                            if (key.indexOf(".") >= 0) {
                                var split = key.split('.')
                                key = split[0] + '\\[' + split[1] + '\\]';
                                if(split[0] == 'images'){
                                    key = split[0]
                                }
                            }

                            $('.form .error_' + key).append(`<span class="text-danger d-block">${value}</span>`);
                            $('[name^=' + key + ']').addClass('border-danger')

                        });
                    }

                },
            });


        });
    });
</script>
<script src="{{asset('admin/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>


